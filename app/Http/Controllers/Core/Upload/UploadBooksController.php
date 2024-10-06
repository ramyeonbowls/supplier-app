<?php

namespace App\Http\Controllers\Core\Upload;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Upload\EncryptBooksRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadBooksController extends Controller
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
        return response()->json($request, 200);
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
        try {
            DB::enableQueryLog();

            $file_cover = '';
            if ($request->hasFile('file_cover')) {
                try {
                    $file_cover = $request->file('file_cover')->getClientOriginalName();

                    $zipObj = new \ZipArchive();
                    $file = $zipObj->open($request->file('file_cover')->path());
                    if ($file === TRUE) {
                        $logs->write('SUCCESS', 'OPEN '.$file_cover);

                        if($zipObj->extractTo(storage_path('app/private/books/'.explode('.', str_replace(' ', '', $file_cover))[0]))) {
                            $zipObj->close();

                            $logs->write('SUCCESS', 'EXTRACT TO '.storage_path('app/private/books/'.explode('.', str_replace(' ', '', $file_cover))[0]));
                        } else {
                            $logs->write('FAILED', 'EXTRACT '.$file_cover);
                        }
                    } else {
                        $logs->write('FAILED', 'OPEN '.$file_cover);
                    }
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $file_pdf = '';
            if ($request->hasFile('file_pdf')) {
                try {
                    $file_pdf = $request->file('file_pdf')->getClientOriginalName();

                    $zipObj = new \ZipArchive();
                    $file = $zipObj->open($request->file('file_pdf')->path());
                    if ($file === TRUE) {
                        $logs->write('SUCCESS', 'OPEN '.$file_pdf);

                        if($zipObj->extractTo(storage_path('app/private/books/'.explode('.', str_replace(' ', '', $file_pdf))[0]))) {
                            $zipObj->close();

                            $logs->write('SUCCESS', 'EXTRACT TO '.storage_path('app/private/books/'.explode('.', str_replace(' ', '', $file_pdf))[0]));
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

            if ($file_cover != '' && $file_pdf != '') {
                $path_pdf = storage_path('app/private/books/'.explode('.', str_replace(' ', '', $file_pdf))[0]);
                $path_cover = storage_path('app/private/books/'.explode('.', str_replace(' ', '', $file_cover))[0]);
                $files = File::files($path_pdf);

                if (File::exists($path_pdf) && File::isDirectory($path_pdf)) {
                    foreach ($files as $key => $file) {
                        $logs->write("INFO", basename($file));

                        $cover_books = '';
                        $extensions = ['jpg', 'png', 'jpeg'];
                        foreach ($extensions as $extension) {
                            $filePath = $path_cover .'/'. explode('.', basename($file))[0] . '.' . $extension;

                            if (File::exists($filePath)) {
                                $cover_books = explode('.', basename($file))[0] . '.' . $extension;
                            }
                        }

                        if ($cover_books) {
                            $fileContent = Storage::get('books/'.explode('.', str_replace(' ', '', $file_pdf))[0].'/'.basename($file));

                            $encryptedContent = encrypt($fileContent);

                            $filename = explode('.', basename($file))[0];
                            Storage::put('books/'.$filename.'.gns', $encryptedContent);
                        }
                    }
                }
            }

           /*  $updated = $this->banner_service->update((object)$validated, $id);
            if ($updated) {
                $logs->write("INFO", "Successfully updated");

                $result['status'] = 201;
                $result['message'] = "Successfully updated.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            } */
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "FAILED updated.<br>" . $th->getMessage();
        }

        return response()->json($result['message'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $id): JsonResponse
    {
        return response()->json($id, 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json($id, 200);
    }
}
