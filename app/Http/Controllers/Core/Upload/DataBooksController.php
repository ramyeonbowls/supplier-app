<?php

namespace App\Http\Controllers\Core\Upload;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Exports\Upload\BookExport;
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
use Spatie\PdfToImage\Pdf;

class DataBooksController extends Controller
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

        $status = $request->status;

        $results = [];
        try {
            DB::enableQueryLog();

            $results = DB::table('tbook_draft as a')->sharedLock()
                ->select(
                    'a.book_id as book_id', 
                    'a.isbn as isbn', 
                    'a.eisbn as eisbn', 
                    'a.title as title', 
                    'a.writer as writer', 
                    'a.publisher_id as publisher_id',
                    'c.description as publisher_desc',
                    'a.size as size', 
                    'a.year as year', 
                    'a.volume as volume', 
                    'a.edition as edition', 
                    'a.page as page', 
                    'a.sinopsis as sinopsis', 
                    'a.sellprice as sellprice', 
                    'a.rentprice as rentprice', 
                    'a.retailprice as retailprice', 
                    'a.city as city', 
                    'a.category_id as category_id', 
                    'b.category_desc as category_desc',
                    'a.book_format_id as book_format_id', 
                    'a.filename as filename', 
                    'a.cover as cover', 
                    'a.age as age', 
                    'a.status as status', 
                    'a.reason as reason', 
                    'a.createdate as createdate',
                )
                ->leftJoin('tcompany_category as b', function($join) {
					$join->on('a.supplier_id', '=', 'b.client_id') 
						->on('a.category_id', '=', 'b.category_id') ;
				})
                ->leftJoin('tpublisher as c', function($join) {
					$join->on('a.supplier_id', '=', 'c.client_id') 
						->on('a.publisher_id', '=', 'c.id') ;
				})
                ->where('a.supplier_id', auth()->user()->client_id)
                ->when(isset($status) && count($status) > 0, function($query) use ($status) {
                    $query->whereIn('a.status', $status);
                })
                ->orderBy('a.status', 'asc')
                ->get();

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return DataTables::of($results->transform(function ($item) {
                foreach ($item as $key => $value) {
                    if (is_null($value)) {
                        $item->$key = '';
                    }
                }
                return $item;
            }))
            ->escapeColumns([])
            ->editColumn('createdate', function ($value) {
                return Carbon::parse($value->createdate)->toDateTimeString();
            })
            ->addColumn('path_cover', function ($value) {
                $path = $value->status != '1' && $value->status != '2' && $value->status != '5' ? 'storage/covers/' : 'storage/covers_draft/';
                return file_exists(public_path($path . $value->cover)) ? $path . $value->cover : '';
            })
            ->addColumn('select', function ($value) {
                return $value->book_id .'|'. $value->status;
            })
            ->addColumn('file_size', function ($value) {
                $path = $value->status != '1' && $value->status != '2' && $value->status != '5' ? 'books/' : 'books_draft/';

                if (Storage::exists($path.'/'.$value->filename)) {
                    $fileSizeInBytes = Storage::size($path.'/'.$value->filename);
                    $fileSizeInMB = $fileSizeInBytes / 1048576;
                    $fileSizeInMB = number_format($fileSizeInMB, 2);
                    return $fileSizeInMB . ' MB';
                }

                return '0 MB';
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'file' => 'required|mimes:zip|max:307200',
            'cover' => 'required|mimes:zip|max:307200',
            'excel' => 'required|mimes:xlsx,xls|max:307200',
        ], [
            'file.required' => 'File Encrypt Zip diperlukan.',
            'file.mimes' => 'File Encrypt Zip bukan zip.',
            'file.max' => 'Ukuran file File Encrypt Zip lebih dari 300mb.',
            'cover.required' => 'File Cover Zip diperlukan.',
            'cover.mimes' => 'File Cover Zip bukan zip.',
            'cover.max' => 'Ukuran file File Cover Zip lebih dari 300mb.',
            'excel.required' => 'File Excel diperlukan.',
            'excel.mimes' => 'File Excel bukan xlsx/xls.',
            'excel.max' => 'Ukuran file File Excel lebih dari 300mb.',
        ]);

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:zip|max:307200',
            'cover' => 'required|mimes:zip|max:307200',
            'excel' => 'required|mimes:xlsx,xls|max:307200',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (!Str::startsWith($request->file('file')->getClientOriginalName(), 'file_')) {
                $validator->errors()->add('file', 'Nama file Encrypt Zip harus dimulai dengan "file_".');
            }
            if (!Str::startsWith($request->file('cover')->getClientOriginalName(), 'cover_')) {
                $validator->errors()->add('cover', 'Nama file Cover Zip harus dimulai dengan "cover_".');
            }
            if (!Str::startsWith($request->file('excel')->getClientOriginalName(), 'detail_')) {
                $validator->errors()->add('excel', 'Nama file Excel harus dimulai dengan "detail_".');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            
        $logs = new Logs( Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");

        $bookFolder = storage_path('app/private/books');
        $coverFolder = storage_path('app/public/covers');
        $bookDraftFolder = storage_path('app/private/books_draft');
        $coveDraftrFolder = storage_path('app/public/covers_draft');
        $bookTmpFolder = storage_path('app/private/books_tmp');
        $coverTmpFolder = storage_path('app/public/covers_tmp');

        if (!File::exists($bookFolder)) {
            File::makeDirectory($bookFolder, 0777, true);
            $logs->write("INFO", "Create folder ". $bookFolder."\r\n");
        }

        if (!File::exists($coverFolder)) {
            File::makeDirectory($coverFolder, 0777, true);
            $logs->write("INFO", "Create folder ". $coverFolder."\r\n");
        }

        if (!File::exists($bookDraftFolder)) {
            File::makeDirectory($bookDraftFolder, 0777, true);
            $logs->write("INFO", "Create folder ". $bookDraftFolder."\r\n");
        }

        if (!File::exists($coveDraftrFolder)) {
            File::makeDirectory($coveDraftrFolder, 0777, true);
            $logs->write("INFO", "Create folder ". $coveDraftrFolder."\r\n");
        }

        if (!File::exists($bookTmpFolder)) {
            File::makeDirectory($bookTmpFolder, 0777, true);
            $logs->write("INFO", "Create folder ". $bookTmpFolder."\r\n");
        }

        if (!File::exists($coverTmpFolder)) {
            File::makeDirectory($coverTmpFolder, 0777, true);
            $logs->write("INFO", "Create folder ". $coverTmpFolder."\r\n");
        }

        try {
            $filePdf = $request->file('file')->getClientOriginalName();

            $zipObj = new \ZipArchive();
            $file = $zipObj->open($request->file('file')->path());
            if ($file === TRUE) {
                $logs->write('SUCCESS', 'OPEN '.$filePdf);

                if ($zipObj->extractTo($bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME))) {
                    $zipObj->close();

                    $logs->write('SUCCESS', 'EXTRACT TO '.$bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME));
                } else {
                    $logs->write('FAILED', 'EXTRACT '.$filePdf);
                }
            } else {
                $logs->write('FAILED', 'OPEN '.$filePdf);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }

        try {
            $fileCover = $request->file('cover')->getClientOriginalName();

            $zipObj = new \ZipArchive();
            $file = $zipObj->open($request->file('cover')->path());
            if ($file === TRUE) {
                $logs->write('SUCCESS', 'OPEN '.$fileCover);

                if ($zipObj->extractTo($coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME))) {
                    $zipObj->close();

                    $logs->write('SUCCESS', 'EXTRACT TO '.$coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME));
                } else {
                    $logs->write('FAILED', 'EXTRACT '.$fileCover);
                }
            } else {
                $logs->write('FAILED', 'OPEN '.$fileCover);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }


        $result['status'] = 200;
        $result['message'] = '';
        $result['data'] = [];

        $spreadsheet = IOFactory::load($request['excel']);
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
                    $fileName       = $worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue();
                    $isbn           = $worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue();
                    $eisbn          = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                    $title          = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
                    $writer         = $worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue();
                    $size           = $worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue();
                    $years          = $worksheet->getCellByColumnAndRow(7, $row)->getFormattedValue();
                    $volume         = $worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue();
                    $edition        = $worksheet->getCellByColumnAndRow(9, $row)->getFormattedValue();
                    $page           = $worksheet->getCellByColumnAndRow(10, $row)->getFormattedValue();
                    $sinopsis       = $worksheet->getCellByColumnAndRow(11, $row)->getFormattedValue();
                    $sellPrice      = $worksheet->getCellByColumnAndRow(12, $row)->getFormattedValue();
                    $rentPrice      = $worksheet->getCellByColumnAndRow(13, $row)->getFormattedValue();
                    $retailPrice    = $worksheet->getCellByColumnAndRow(14, $row)->getFormattedValue();
                    $city           = $worksheet->getCellByColumnAndRow(15, $row)->getFormattedValue();
                    $ages           = $worksheet->getCellByColumnAndRow(16, $row)->getFormattedValue();

                    if (File::exists($bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME).'/'.$fileName)) {
                        $fileTmpPdf = $bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME).'/'.$fileName;
                        $fileTmpPdfName = pathinfo($fileTmpPdf, PATHINFO_FILENAME);
                        $fileTmpPdfExt = pathinfo($fileTmpPdf, PATHINFO_EXTENSION);
                        $fileTmpPdfSize = filesize($fileTmpPdf);
                    } else {
                        $fileTmpPdf = '';
                        $fileTmpPdfName = '';
                        $fileTmpPdfExt = '';
                        $fileTmpPdfSize = 0;
                    }
    
                    if (File::exists($coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.jpg')) {
                        $fileTmpCover = $coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.jpg';
                        $fileTmpCoverName = pathinfo($fileTmpCover, PATHINFO_FILENAME);
                        $fileTmpCoverExt = pathinfo($fileTmpCover, PATHINFO_EXTENSION);
                        $fileTmpCoverSize = filesize($fileTmpCover);
                    } else {
                        $fileTmpCover = '';
                        $fileTmpCoverName = '';
                        $fileTmpCoverExt = '';
                        $fileTmpCoverSize = 0;
                    }

                    if (empty($fileName) || empty($isbn) || empty($eisbn) || empty($title) || empty($writer) || empty($size) || empty($years) || empty($volume) || empty($edition) || empty($page) || empty($sinopsis) || !is_numeric($sellPrice) || !is_numeric($rentPrice) || !is_numeric($retailPrice) || empty($city) || !is_numeric($ages) || $fileTmpPdfSize <= 0 || $fileTmpCoverSize <= 0) {
                        $data_excel['failed'][$i][$ii]['bookId']        = '';
                        $data_excel['failed'][$i][$ii]['fileName']      = empty($fileName) ? 'Kosong' : $fileName;
                        $data_excel['failed'][$i][$ii]['isbn']          = empty($isbn) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['eisbn']         = empty($eisbn) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['title']         = empty($title) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['writer']        = empty($writer) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['size']          = empty($size) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['years']         = empty($years) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['volume']        = empty($volume) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['edition']       = empty($edition) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['page']          = empty($page) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['sinopsis']      = empty($sinopsis) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['sellPrice']     = is_numeric($sellPrice) ? '' : 'Bukan Angka';
                        $data_excel['failed'][$i][$ii]['rentPrice']     = is_numeric($rentPrice) ? '' : 'Bukan Angka';
                        $data_excel['failed'][$i][$ii]['retailPrice']   = is_numeric($retailPrice) ? '' : 'Bukan Angka';
                        $data_excel['failed'][$i][$ii]['city']          = empty($city) ? 'Kosong' : '';
                        $data_excel['failed'][$i][$ii]['ages']          = is_numeric($ages) ? '' : 'Bukan Angka';
                        $data_excel['failed'][$i][$ii]['fileExist']     = ($fileTmpPdfSize <= 0 && $fileTmpCoverSize <= 0) ? $fileTmpPdfName.' Tidak Ada' : '';
                        $data_excel['failed'][$i][$ii]['coverExist']    = ($fileTmpPdfSize <= 0 && $fileTmpCoverSize <= 0) ? $fileTmpPdfName.' Tidak Ada' : '';
                        $data_excel['failed'][$i][$ii]['coverFile']     = file_exists(public_path('storage/covers_draft/' . $fileTmpPdfName.'.jpg')) ? 'storage/covers_draft/' . $fileTmpPdfName.'.jpg' : '';
                        $data_excel['failed'][$i][$ii]['publisher']     = '';
                        $data_excel['failed'][$i][$ii]['category']      = '';
                    } else {
                        $exists = DB::table('tbook_draft')->sharedLock()->where('isbn', $isbn)->first('isbn');
    
                        $tagging = 'new';
                        if ($exists) {
                            $tagging = 'exists';
                        }
    
                        $data_excel[$tagging][$i][$ii]['bookId']        = $tagging == 'new' ? Str::uuid() : '';
                        $data_excel[$tagging][$i][$ii]['fileName']      = $fileName;
                        $data_excel[$tagging][$i][$ii]['isbn']          = $isbn;
                        $data_excel[$tagging][$i][$ii]['eisbn']         = $eisbn;
                        $data_excel[$tagging][$i][$ii]['title']         = $title;
                        $data_excel[$tagging][$i][$ii]['writer']        = $writer;
                        $data_excel[$tagging][$i][$ii]['size']          = $size;
                        $data_excel[$tagging][$i][$ii]['years']         = $years;
                        $data_excel[$tagging][$i][$ii]['volume']        = $volume;
                        $data_excel[$tagging][$i][$ii]['edition']       = $edition;
                        $data_excel[$tagging][$i][$ii]['page']          = $page;
                        $data_excel[$tagging][$i][$ii]['sinopsis']      = $sinopsis;
                        $data_excel[$tagging][$i][$ii]['sellPrice']     = $sellPrice;
                        $data_excel[$tagging][$i][$ii]['rentPrice']     = $rentPrice;
                        $data_excel[$tagging][$i][$ii]['retailPrice']   = $retailPrice;
                        $data_excel[$tagging][$i][$ii]['city']          = $city;
                        $data_excel[$tagging][$i][$ii]['ages']          = $ages;
                        $data_excel[$tagging][$i][$ii]['fileExist']     = '';
                        $data_excel[$tagging][$i][$ii]['coverExist']    = '';
                        $data_excel[$tagging][$i][$ii]['coverFile']     = file_exists(public_path('storage/covers_draft/' . $fileTmpPdfName.'.jpg')) ? 'storage/covers_draft/' . $fileTmpPdfName.'.jpg' : '';
                        $data_excel[$tagging][$i][$ii]['publisher']     = '';
                        $data_excel[$tagging][$i][$ii]['category']      = '';
                    }

                    $ii++;
                }
            }

            $logs->write('INFO', 'Worksheet Title: '. $worksheetTitle."\r\n");
        }

        try {
            DB::enableQueryLog();
            
            $collect_exists_data    = collect($data_excel['exists'])->collapse()->all();
            $collect_failed_data    = collect($data_excel['failed'])->collapse()->all();
            $collect_new_data       = collect($data_excel['new'])->collapse()->all();

            foreach ($collect_new_data as $key => $value) {
                if (File::exists($bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME).'/'.$value['fileName'])) {
                    $fileTmpPdf = $bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME).'/'.$value['fileName'];
                    $fileTmpPdfName = pathinfo($fileTmpPdf, PATHINFO_FILENAME);
                    $fileTmpPdfExt = pathinfo($fileTmpPdf, PATHINFO_EXTENSION);
                    $fileTmpPdfSize = filesize($fileTmpPdf);
                } else {
                    $fileTmpPdf = '';
                    $fileTmpPdfName = '';
                    $fileTmpPdfExt = '';
                    $fileTmpPdfSize = 0;
                }

                if (File::exists($coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.jpg')) {
                    $fileTmpCover = $coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.jpg';
                    $fileTmpCoverName = pathinfo($fileTmpCover, PATHINFO_FILENAME);
                    $fileTmpCoverExt = pathinfo($fileTmpCover, PATHINFO_EXTENSION);
                    $fileTmpCoverSize = filesize($fileTmpCover);
                } else {
                    $fileTmpCover = '';
                    $fileTmpCoverName = '';
                    $fileTmpCoverExt = '';
                    $fileTmpCoverSize = 0;
                }

                if ($fileTmpPdfSize > 0 && $fileTmpCoverSize > 0) {
                    $movePdf = Storage::move('books_tmp/'.pathinfo($filePdf, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.'.$fileTmpPdfExt, 'books_draft/'.$fileTmpPdfName.'.'.$fileTmpPdfExt);
                    $logs->write('INFO', 'MOVE '. 'books_tmp/'.pathinfo($filePdf, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.'.$fileTmpPdfExt .' TO '. 'books_draft/'.$fileTmpPdfName.'.'.$fileTmpPdfExt);

                    $moveCover = File::move(public_path('storage/covers_tmp/'.pathinfo($fileCover, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.jpg'), public_path('storage/covers_draft/'.$fileTmpPdfName.'.jpg'));
                    $logs->write('INFO', 'MOVE '. public_path('storage/covers_tmp/'.pathinfo($fileCover, PATHINFO_FILENAME).'/'.$fileTmpPdfName.'.jpg') .' TO '. public_path('storage/covers_draft/'.$fileTmpPdfName.'.jpg'));
                    
                    if ($movePdf && $moveCover) {
                        $data = [
                            'book_id'       => $value['bookId'],
                            'supplier_id'   => auth()->user()->client_id,
                            'isbn'          => $value['isbn'],
                            'eisbn'         => $value['eisbn'],
                            'title'         => $value['title'],
                            'writer'        => $value['writer'],
                            'size'          => $value['size'],
                            'year'          => $value['years'],
                            'volume'        => $value['volume'],
                            'edition'       => $value['edition'],
                            'page'          => $value['page'],
                            'sinopsis'      => $value['sinopsis'],
                            'sellprice'     => $value['sellPrice'],
                            'rentprice'     => $value['rentPrice'],
                            'retailprice'   => $value['retailPrice'],
                            'city'          => $value['city'],
                            'publisher_id'  => '',
                            'category_id'   => '',
                            'book_format_id'=> '',
                            'filename'      => $fileTmpPdfName.'.'.$fileTmpPdfExt,
                            'cover'         => $fileTmpPdfName.'.jpg',
                            'age'           => $value['ages'],
                            'status'        => 1,
                            'createdate'    => Carbon::now('Asia/Jakarta'),
                            'createby'      => auth()->user()->email,
                            'updatedate'    => Carbon::now('Asia/Jakarta'),
                            'updateby'      => auth()->user()->email,
                        ];

                        $tbook_draft = DB::table('tbook_draft')->insert($data);
                    }
                }
            }

            File::deleteDirectory($bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME));
            $logs->write("INFO", "Delete folder ". $bookTmpFolder.'/'.pathinfo($filePdf, PATHINFO_FILENAME)."\r\n");
            File::deleteDirectory($coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME));
            $logs->write("INFO", "Delete folder ". $coverTmpFolder.'/'.pathinfo($fileCover, PATHINFO_FILENAME)."\r\n");

            $result['message'] .= "<span class='font-bold'>Berhasil</span>: ". count($collect_new_data) ." data";
            $result['message'] .= "<br/><span class='font-bold'>Gagal</span>: ". count($collect_failed_data) + count($collect_exists_data)  ." data";

            $result['data'] = $data_excel;

            $queries = DB::getQueryLog();
            for($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed upload file.<br>". $th->getMessage();
        }

        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json(['message' => $result['message'], 'data' => $result['data']], $result['status']);
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

                    $ketegori = DB::table('tcompany_category as a')->sharedLock()
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
        //
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadFile(Request $request)
    {
        if (Storage::exists('books/'. str_replace('&amp;', '&', $request->file))) {
            $filePath = 'books/'.$request->file;
            $fileContent = Storage::get($filePath);
        } else {
            $filePath = 'books_draft/'.$request->file;
            $fileContent = Storage::get($filePath);
        }

        return response()->make($fileContent, 200, [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Type'          => Storage::mimeType($filePath),
            'Content-Length'        => Storage::size($filePath),
            'Content-Disposition'   => 'attachment; filename="' . basename($filePath) . '"',
            'Pragma'                => 'public',
        ]);
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

            foreach ($request->all()[0] as $key => $value) {
                $updated = DB::table('tbook_draft')
                    ->where('supplier_id', auth()->user()->client_id)
                    ->where('book_id', $value['bookId'])
                    ->update([
                        'status' => '2',
                        'publisher_id' => $value['publisher'],
                        'category_id' => $value['category'],
                        'updatedate' => Carbon::now('Asia/Jakarta'),
                        'updateby' => auth()->user()->email,
                    ]);
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
    public function exportData(Request $request): BinaryFileResponse
    {
        return Excel::download(new BookExport([]), 'data_buku.xlsx');
    }
}
