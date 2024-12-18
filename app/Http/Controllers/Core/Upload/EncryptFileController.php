<?php

namespace App\Http\Controllers\Core\Upload;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Exports\Upload\UploadEncryptExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Upload\EncryptBooksRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;
use Spatie\PdfToImage\Pdf;

class EncryptFileController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(['request' => $request], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EncryptBooksRequest  $request
     * @return JsonResponse
     */
    public function store(EncryptBooksRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        $result['file'] = [];
        $result['filename'] = [];
        try {
            $zip_folder = storage_path('app/private/files');

            if (!File::exists($zip_folder)) {
                File::makeDirectory($zip_folder, 0777, true);
            }

            $file_pdf = '';
            if ($request->hasFile('file_pdf')) {
                try {
                    $file_pdf = $request->file('file_pdf')->getClientOriginalName();

                    $zipObj = new \ZipArchive();
                    $file = $zipObj->open($request->file('file_pdf')->path());
                    if ($file === TRUE) {
                        $logs->write('SUCCESS', 'OPEN '.$file_pdf);

                        if ($zipObj->extractTo($zip_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME))) {
                            $zipObj->close();

                            $logs->write('SUCCESS', 'EXTRACT TO '.$zip_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME));
                        } else {
                            $logs->write('FAILED', 'EXTRACT '.$file_pdf);
                        }
                    } else {
                        $logs->write('FAILED', 'OPEN '.$file_pdf);
                    }
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $validSize = true;
            if ($file_pdf != '') {
                $path_pdf = $zip_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME);

                $files = File::files($path_pdf);
                
                if (File::exists($path_pdf) && File::isDirectory($path_pdf)) {
                    foreach ($files as $key => $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                            $fileContent = Storage::size('files/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.basename($file));
                            $logs->write('info', $fileContent);

                            if ($fileContent > 20000000) {
                                $validSize = false;
                                $logs->write('failed', basename($file) . ' Ukuran File lebih dari 20mb.');
                                $result['status'] = 500;
                                $result['message'] = "Failed upload " . basename($file) . " Ukuran File lebih dari 20mb.";
                                break;
                            }
                        }
                    }

                    if (!$validSize) {
                        File::deleteDirectory($path_pdf);
                        return response()->json($result, $result['status']);
                    }
                }
            }

            if ($file_pdf != '') {
                $path_pdf = $zip_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME);
                $zipFileName = pathinfo($file_pdf, PATHINFO_FILENAME).'.zip';

                $files = File::files($path_pdf);

                $books = [];
                if (File::exists($path_pdf) && File::isDirectory($path_pdf)) {
                    foreach ($files as $key => $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                            $pdfPath = $zip_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.basename($file);
                            $pdf = new \Spatie\PdfToImage\Pdf($pdfPath);
                            $cover_name = pathinfo($file, PATHINFO_FILENAME).'.jpg';
                            $outputPath = $zip_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.$cover_name;
                            $pdf->selectPage(1)->save($outputPath);
                            
                            $fileContent = Storage::get('files/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.basename($file));

                            $encryptedContent = encrypt($fileContent);

                            $filename = pathinfo($file, PATHINFO_FILENAME);
                            $encryptFile = Storage::put('files/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.$filename.'.gns', $encryptedContent);

                            Storage::delete('files/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.basename($file));
                        } else {
                            $result['status'] = 500;
                            $result['message'] = "Failed upload " . basename($file) . " Not PDF Extension.";
                        }
                    }

                    $zip = new \ZipArchive;
                    $fname = 'file_'.$zipFileName;
                    $zipPath = $zip_folder.'/'.$fname;

                    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                        $filesToZip = File::allFiles($path_pdf);

                        foreach ($filesToZip as $file) {
                            $relativeName = basename($file);
                            if (pathinfo($relativeName, PATHINFO_EXTENSION) == 'gns') {
                                $result['filename'][] = basename($file);
                                $zip->addFile($file, $relativeName);
                            }
                        }

                        $zip->close();

                        $result['file'][] = $fname;
                    } else {
                        $result['status'] = 500;
                        $result['message'] = "Failed to create zip file.";
                    }

                    $zip = new \ZipArchive;
                    $fname = 'cover_'.$zipFileName;
                    $zipPath = $zip_folder.'/'.$fname;

                    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                        $filesToZip = File::allFiles($path_pdf);

                        foreach ($filesToZip as $file) {
                            $relativeName = basename($file);
                            if (pathinfo($relativeName, PATHINFO_EXTENSION) != 'gns') {
                                $zip->addFile($file, $relativeName);
                            }
                        }

                        $zip->close();

                        $result['file'][] = $fname;
                    } else {
                        $result['status'] = 500;
                        $result['message'] = "Failed to create zip file.";
                    }
                }

                File::deleteDirectory($path_pdf);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['status'] = 500;
            $result['message'] = "Failed upload.<br>" . $th->getMessage();
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(['id' => $id], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json(['request' => $request], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json(['id' => $id], 200);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadFile(Request $request)
    {
        $filePath = 'files/'.$request->file;
        $fileContent = Storage::get($filePath);

        return response()->make($fileContent, 200, [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Type'          => Storage::mimeType($filePath),
            'Content-Length'        => Storage::size($filePath),
            'Content-Disposition'   => 'attachment; filename="' . basename($filePath) . '"',
            'Pragma'                => 'public',
        ]);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportTpl(Request $request): BinaryFileResponse
    {
        return Excel::download(new UploadEncryptExport($request->data), 'detail_data.xlsx');
    }
}
