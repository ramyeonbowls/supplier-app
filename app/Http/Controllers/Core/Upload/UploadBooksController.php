<?php

namespace App\Http\Controllers\Core\Upload;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Exports\Upload\UploadBookExport;
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
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $results = [];
        try {
            DB::enableQueryLog();

            $results = DB::table('tbook_draft as a')->sharedLock()
                ->select('a.book_id', 'a.isbn', 'a.eisbn', 'a.title', 'a.writer', 'a.publisher_id', 'a.size', 'a.year', 'a.volume', 'a.edition', 'a.page', 'a.sinopsis', 'a.sellprice', 'a.rentprice', 'a.retailprice', 'a.city', 'a.category_id', 'a.book_format_id', 'a.filename', 'a.cover', 'a.age', 'a.status', 'a.reason', 'a.createdate', 'a.createby', 'a.updatedate', 'a.updateby')
                ->where('a.supplier_id', auth()->user()->client_id)
                ->get();

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return DataTables::of($results)
            ->escapeColumns()
            ->editColumn('createdate', function ($value) {
                return Carbon::parse($value->createdate)->toDateTimeString();
            })
            ->editColumn('updatedate', function ($value) {
                return Carbon::parse($value->updatedate)->toDateTimeString();
            })
            ->addIndexColumn()
            ->toJson();
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
        $results['message'] = [];
        $results['error'] = [];
        $results['data'] = [];
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

                        if($zipObj->extractTo(storage_path('app/private/tmp/'.explode('.', str_replace(' ', '', $file_cover))[0]))) {
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

                        if($zipObj->extractTo(storage_path('app/private/tmp/'.explode('.', str_replace(' ', '', $file_pdf))[0]))) {
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
                $path_pdf = storage_path('app/private/tmp/'.explode('.', str_replace(' ', '', $file_pdf))[0]);
                $path_cover = storage_path('app/private/tmp/'.explode('.', str_replace(' ', '', $file_cover))[0]);

                $files = File::files($path_pdf);

                $books = [];
                if (File::exists($path_pdf) && File::isDirectory($path_pdf)) {
                    foreach ($files as $key => $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                            $cover_books = '';
                            $extensions = ['jpg', 'png', 'jpeg'];
                            foreach ($extensions as $extension) {
                                $filePath = $path_cover .'/'. pathinfo($file, PATHINFO_FILENAME) . '.' . $extension;

                                if (File::exists($filePath)) {
                                    $cover_books = pathinfo($file, PATHINFO_FILENAME) . '.' . $extension;
                                    File::move($filePath, storage_path('app/private/covers/'.$cover_books));
                                } 
                            }

                            if ($cover_books) {
                                $fileContent = Storage::get('books/'.pathinfo($file, PATHINFO_FILENAME).'/'.basename($file));

                                $encryptedContent = encrypt($fileContent);

                                $filename = Carbon::now()->format('ymdHis').' '.pathinfo($file, PATHINFO_FILENAME);
                                $encryptFile = Storage::put('books/'.$filename.'.gns', $encryptedContent);

                                if ($encryptFile) {
                                    $books_id = Str::uuid();
                                    $upload = DB::table('tbook_tmp')->insert([
                                            'book_id' => $books_id,
                                            'filename' => $filename . '.gns',
                                            'cover' => $cover_books,
                                            'flag' => '1',
                                            'supplier_id' => auth()->user()->client_id,
                                            'createdate' => Carbon::now('Asia/Jakarta'),
                                            'createby' => auth()->user()->email,
                                            'updatedate' => Carbon::now('Asia/Jakarta'),
                                            'updateby' => auth()->user()->email
                                        ]);
                                    if ($upload) {
                                        $books[] = $books_id->toString(); 

                                        $logs->write("INFO", "Successfully upload ". basename($file));
                                        $results['message'][] = "Successfully Encrypt " . basename($file);
                                    }
                                }
                            } else {
                                $results['error'][] = "Failed upload " . basename($file) . " Not Found.";
                            }
                        } else {
                            $results['error'][] = "Failed upload " . basename($file) . " Not PDF Extension.";
                        }
                    }
                }

                $data = DB::table('tbook_tmp as a')->sharedLock()
                    ->select(
                        'a.book_id',
                        'a.filename',
                        'a.cover',
                        'a.category_id',
                        'a.book_format_id'
                    )
                    ->whereIn('a.book_id', $books)
                    ->where('a.supplier_id', auth()->user()->client_id)
                    ->get();

                $rslt = $data->map(function($value, $key) {
                    return [
                        'book_id' => $value->book_id ?? '',
                        'filename' => $value->filename ?? '',
                        'cover' => $value->cover ?? '',
                        'category_id' => $value->category_id ?? '',
                        'publisher_id' => $value->publisher_id ?? '',
                        'book_format_id' => $value->book_format_id ?? '',
                    ];
                });

                $results['data'] = $rslt;
            }

            File::deleteDirectory($path_pdf);
            File::deleteDirectory($path_cover);

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $results['error'][] = "Failed upload.<br>" . $th->getMessage();
        }

        return response()->json($results, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $id): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');

        if (request()->has('param') && request()->param != '') {
            switch (request()->param) {
                case 'category-mst':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tclient_category as a')->sharedLock()
                        ->select(
                            'a.category_id as id',
                            'a.category_desc as name'
                        )
                        ->where('client_id', auth()->user()->client_id)
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($ketegori) {
                        $results = $ketegori->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'publisher-mst':
                    DB::enableQueryLog();

                    $publisher = DB::table('tpublisher as a')->sharedLock()
                        ->select(
                            'a.id as id',
                            'a.description as name'
                        )
                        ->where('client_id', auth()->user()->client_id)
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($publisher) {
                        $results = $publisher->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'format-mst':
                    DB::enableQueryLog();

                    $format = DB::table('tbook_format as a')->sharedLock()
                        ->select(
                            'a.book_format_id as id',
                            'a.description as name'
                        )
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($format) {
                        $results = $format->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'preview-data':
                    DB::enableQueryLog();

                    $books = [];
                    foreach (request()->data as $key => $value) {
                        $books[] = $value['book_id'];
                    }

                    $data = DB::table('tbook_tmp as a')->sharedLock()
                        ->select(
                            'a.book_id',
                            'a.supplier_id',
                            'a.isbn',
                            'a.eisbn',
                            'a.title',
                            'a.writer',
                            'a.publisher_id',
                            'a.size',
                            'a.year',
                            'a.volume',
                            'a.edition',
                            'a.page',
                            'a.sinopsis',
                            'a.sellprice',
                            'a.rentprice',
                            'a.retailprice',
                            'a.city',
                            'a.category_id',
                            'a.book_format_id',
                            'a.filename',
                            'a.cover',
                            'a.age',
                            'a.flag'
                        )
                        ->whereIn('a.book_id', $books)
                        ->where('a.supplier_id', auth()->user()->client_id)
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($data) {
                        $results = $data->map(function($value, $key) {
                            return [
                                'book_id' => $value->book_id ?? '',
                                'supplier_id' => $value->supplier_id ?? '',
                                'isbn' => $value->isbn ?? '',
                                'eisbn' => $value->eisbn ?? '',
                                'title' => $value->title ?? '',
                                'writer' => $value->writer ?? '',
                                'publisher_id' => $value->publisher_id ?? '',
                                'size' => $value->size ?? '',
                                'year' => $value->year ?? '',
                                'volume' => $value->volume ?? '',
                                'edition' => $value->edition ?? '',
                                'page' => $value->page ?? '',
                                'sinopsis' => $value->sinopsis ?? '',
                                'sellprice' => $value->sellprice ?? '',
                                'rentprice' => $value->rentprice ?? '',
                                'retailprice' => $value->retailprice ?? '',
                                'city' => $value->city ?? '',
                                'category_id' => $value->category_id ?? '',
                                'book_format_id' => $value->book_format_id ?? '',
                                'filename' => $value->filename ?? '',
                                'cover' => $value->cover ?? '',
                                'age' => $value->age ?? '',
                                'flag' => $value->flag ?? '',
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                default:
                    return response()->json(request()->param, 200);
                break;
            }
        }
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
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            foreach ($request->all() as $key => $value) {
                if (is_array($value)) {
                    $updated = DB::table('tbook_tmp')
                        ->where('supplier_id', auth()->user()->client_id)
                        ->where('book_id', $value['book_id'])
                        ->update([
                            'category_id' => $value['category_id'],
                            'publisher_id' => $value['publisher_id'],
                            'book_format_id' => $value['book_format_id'],
                            'updatedate' => Carbon::now('Asia/Jakarta'),
                            'updateby' => auth()->user()->email
                        ]);
                }
            }
            
            if ($updated) {
                $logs->write("INFO", "Successfully updated");

                $result['status'] = 201;
                $result['message'] = "Successfully updated.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed updated.<br>" . $th->getMessage();
        }

        return response()->json($result['message'], $result['status']);
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

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function submitDraft(Request $request): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            foreach ($request->all() as $key => $value) {
                if (is_array($value)) {
                    $updated = DB::table('tbook_draft')
                        ->insert([
                            'book_id' => $value['book_id'],
                            'supplier_id' => $value['supplier_id'],
                            'isbn' => $value['isbn'],
                            'eisbn' => $value['eisbn'],
                            'title' => $value['title'],
                            'writer' => $value['writer'],
                            'publisher_id' => $value['publisher_id'],
                            'size' => $value['size'],
                            'year' => $value['year'],
                            'volume' => $value['volume'],
                            'edition' => $value['edition'],
                            'page' => $value['page'],
                            'sinopsis' => $value['sinopsis'],
                            'sellprice' => $value['sellprice'],
                            'rentprice' => $value['rentprice'],
                            'retailprice' => $value['retailprice'],
                            'city' => $value['city'],
                            'category_id' => $value['category_id'],
                            'book_format_id' => $value['book_format_id'],
                            'filename' => $value['filename'],
                            'cover' => $value['cover'],
                            'age' => $value['age'],
                            'status' => '2',
                            'reason' => '',
                            'createdate' => Carbon::now('Asia/Jakarta'),
                            'createby' => auth()->user()->email,
                            'updatedate' => Carbon::now('Asia/Jakarta'),
                            'updateby' => auth()->user()->email,
                        ]);
                }
            }
            
            if ($updated) {
                $logs->write("INFO", "Successfully listing to Review");

                $result['status'] = 201;
                $result['message'] = "Successfully listing to Review.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed listing to Review.<br>" . $th->getMessage();
        }

        return response()->json($result['message'], $result['status']);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportTpl(Request $request): BinaryFileResponse
    {
        $books = [];
        foreach ($request->data as $key => $value) {
            $books[] = $value['book_id'];
        }

        return Excel::download(new UploadBookExport($books), 'detail_data.xlsx');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadExcel(Request $request): JsonResponse
    {
        $logs = new Logs( Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");

        $result['status'] = 200;
        $result['message']= '';

        $spreadsheet = IOFactory::load($request['file_master']);
        $sheetCount  = $spreadsheet->getSheetCount();

        $logs->write('INFO', 'sheetCount:'. $sheetCount);
        $data_excel['new'] = $data_excel['exists'] = $data_excel['failed'] = [];
        foreach ($spreadsheet->getWorksheetIterator() as $i => $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $worksheetTitle_A   = explode(" ", $worksheetTitle);

            $logs->write('INFO', 'Worksheet Title: '. $worksheetTitle);
            $logs->write('INFO', 'Total row: '. ($highestRow - 1));

            if($worksheetTitle_A[0] == 'DATA') {
                $ii = 0;
                for($row = 2; $row <= $highestRow; $row++) {
                    $book_id            = $worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue();
                    $filename           = $worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue();
                    $isbn               = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                    $eisbn              = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
                    $title              = $worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue();
                    $writer             = $worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue();
                    $size               = $worksheet->getCellByColumnAndRow(7, $row)->getFormattedValue();
                    $year               = $worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue();
                    $volume             = $worksheet->getCellByColumnAndRow(9, $row)->getFormattedValue();
                    $edition            = $worksheet->getCellByColumnAndRow(10, $row)->getFormattedValue();
                    $page               = $worksheet->getCellByColumnAndRow(11, $row)->getFormattedValue();
                    $sinopsis           = $worksheet->getCellByColumnAndRow(12, $row)->getFormattedValue();
                    $sellprice          = $worksheet->getCellByColumnAndRow(13, $row)->getFormattedValue();
                    $rentprice          = $worksheet->getCellByColumnAndRow(14, $row)->getFormattedValue();
                    $retailprice        = $worksheet->getCellByColumnAndRow(15, $row)->getFormattedValue();
                    $city               = $worksheet->getCellByColumnAndRow(16, $row)->getFormattedValue();
                    $age                = $worksheet->getCellByColumnAndRow(17, $row)->getFormattedValue();

                    if ($isbn != '' || $eisbn != '' || $title != '' || $writer != '' || $size != '' || $year != '' || $volume != '' || $edition != '' || $page != '' || $sinopsis != '' || $sellprice != '' || $rentprice != '' || $retailprice != '' || $city != '' || $age != '') {
                        $tagging = 'exists';

                        $data_excel[$tagging][$i][$ii]['book_id'] = $book_id;
                        $data_excel[$tagging][$i][$ii]['filename'] = $filename;
                        $data_excel[$tagging][$i][$ii]['isbn'] = $isbn;
                        $data_excel[$tagging][$i][$ii]['eisbn'] = $eisbn;
                        $data_excel[$tagging][$i][$ii]['title'] = $title;
                        $data_excel[$tagging][$i][$ii]['writer'] = $writer;
                        $data_excel[$tagging][$i][$ii]['size'] = $size;
                        $data_excel[$tagging][$i][$ii]['year'] = $year;
                        $data_excel[$tagging][$i][$ii]['volume'] = $volume;
                        $data_excel[$tagging][$i][$ii]['edition'] = $edition;
                        $data_excel[$tagging][$i][$ii]['page'] = $page;
                        $data_excel[$tagging][$i][$ii]['sinopsis'] = $sinopsis;
                        $data_excel[$tagging][$i][$ii]['sellprice'] = $sellprice;
                        $data_excel[$tagging][$i][$ii]['rentprice'] = $rentprice;
                        $data_excel[$tagging][$i][$ii]['retailprice'] = $retailprice;
                        $data_excel[$tagging][$i][$ii]['city'] = $city;
                        $data_excel[$tagging][$i][$ii]['age'] = $age;
                    } else {
                        $tagging = 'failed';

                        $data_excel[$tagging][$i][$ii]['book_id'] = $book_id;
                        $data_excel[$tagging][$i][$ii]['filename'] = $filename;
                        $data_excel[$tagging][$i][$ii]['isbn'] = $isbn;
                        $data_excel[$tagging][$i][$ii]['eisbn'] = $eisbn;
                        $data_excel[$tagging][$i][$ii]['title'] = $title;
                        $data_excel[$tagging][$i][$ii]['writer'] = $writer;
                        $data_excel[$tagging][$i][$ii]['size'] = $size;
                        $data_excel[$tagging][$i][$ii]['year'] = $year;
                        $data_excel[$tagging][$i][$ii]['volume'] = $volume;
                        $data_excel[$tagging][$i][$ii]['edition'] = $edition;
                        $data_excel[$tagging][$i][$ii]['page'] = $page;
                        $data_excel[$tagging][$i][$ii]['sinopsis'] = $sinopsis;
                        $data_excel[$tagging][$i][$ii]['sellprice'] = $sellprice;
                        $data_excel[$tagging][$i][$ii]['rentprice'] = $rentprice;
                        $data_excel[$tagging][$i][$ii]['retailprice'] = $retailprice;
                        $data_excel[$tagging][$i][$ii]['city'] = $city;
                        $data_excel[$tagging][$i][$ii]['age'] = $age;
                    }

                    $ii++;
                }
            }

            $logs->write('INFO', 'Worksheet Title: '. $worksheetTitle."\r\n");
        }

        try {
            DB::enableQueryLog();

            $collect_exists_data = collect($data_excel['exists'])->collapse()->all();
            $exists_count = 0;
            foreach ($collect_exists_data as $i => $value) {
                $updated = DB::table('tbook_tmp')
                    ->where('supplier_id', auth()->user()->client_id)
                    ->where('book_id', $value['book_id'])
                    ->update([
                        'isbn' => $value['isbn'],
                        'eisbn' => $value['eisbn'],
                        'title' => $value['title'],
                        'writer' => $value['writer'],
                        'size' => $value['size'],
                        'year' => $value['year'],
                        'volume' => $value['volume'],
                        'edition' => $value['edition'],
                        'page' => $value['page'],
                        'sinopsis' => $value['sinopsis'],
                        'sellprice' => $value['sellprice'],
                        'rentprice' => $value['rentprice'],
                        'retailprice' => $value['retailprice'],
                        'city' => $value['city'],
                        'age' => $value['age'],
                        'updatedate' => Carbon::now('Asia/Jakarta'),
                        'updateby' => auth()->user()->email
                    ]);
                    
                if ($updated) {
                    $exists_count += 1;
                }
            }

            $collect_failed_data = collect($data_excel['failed'])->collapse()->all();

            $result['status'] = 201;
            $result['message'] .= "Successfully updated: ". $exists_count ." data";

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed upload file.<br>". $th->getMessage();
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadFile(Request $request)
    {
        $filePath = $request->data.'/'.$request->file;
        $fileContent = Storage::get($filePath);

        return response()->make($fileContent, 200, [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Type'          => Storage::mimeType($filePath),
            'Content-Length'        => Storage::size($filePath),
            'Content-Disposition'   => 'attachment; filename="' . basename($filePath) . '"',
            'Pragma'                => 'public',
        ]);
    }
}
