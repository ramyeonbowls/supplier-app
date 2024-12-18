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
use Spatie\PdfToImage\Pdf;

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

        return DataTables::of($results)
            ->escapeColumns([])
            ->editColumn('book_id', function ($value) {
                return $value->book_id ?? '';
            })
            ->editColumn('isbn', function ($value) {
                return $value->isbn ?? '';
            })
            ->editColumn('eisbn', function ($value) {
                return $value->eisbn ?? '';
            })
            ->editColumn('title', function ($value) {
                return $value->title ?? '';
            })
            ->editColumn('writer', function ($value) {
                return $value->writer ?? '';
            })
            ->editColumn('publisher_id', function ($value) {
                return $value->publisher_id ?? '';
            })
            ->editColumn('publisher_desc', function ($value) {
                return $value->publisher_desc ?? '';
            })
            ->editColumn('size', function ($value) {
                return $value->size ?? '';
            })
            ->editColumn('year', function ($value) {
                return $value->year ?? '';
            })
            ->editColumn('volume', function ($value) {
                return $value->volume ?? '';
            })
            ->editColumn('edition', function ($value) {
                return $value->edition ?? '';
            })
            ->editColumn('page', function ($value) {
                return $value->page ?? '';
            })
            ->editColumn('sinopsis', function ($value) {
                return $value->sinopsis ?? '';
            })
            ->editColumn('sellprice', function ($value) {
                return number_format($value->sellprice, 0, 2) ?? '';
            })
            ->editColumn('rentprice', function ($value) {
                return number_format($value->rentprice, 0, 2) ?? '';
            })
            ->editColumn('retailprice', function ($value) {
                return number_format($value->retailprice, 0, 2) ?? '';
            })
            ->editColumn('city', function ($value) {
                return $value->city ?? '';
            })
            ->editColumn('category_id', function ($value) {
                return $value->category_id ?? '';
            })
            ->editColumn('category_desc', function ($value) {
                return $value->category_desc ?? '';
            })
            ->editColumn('book_format_id', function ($value) {
                return $value->book_format_id ?? '';
            })
            ->editColumn('filename', function ($value) {
                return $value->filename ?? '';
            })
            ->editColumn('cover', function ($value) {
                return $value->cover ?? '';
            })
            ->editColumn('age', function ($value) {
                return $value->age ?? '';
            })
            ->editColumn('status', function ($value) {
                return $value->status ?? '';
            })
            ->editColumn('reason', function ($value) {
                return $value->reason ?? '';
            })
            ->editColumn('createdate', function ($value) {
                return Carbon::parse($value->createdate)->toDateTimeString();
            })
            ->addColumn('path_cover', function ($value) {
                $path = $value->status != '1' && $value->status != '2' && $value->status != '5' ? 'storage/covers/' : 'storage/tmp/covers_tmp/';
                return file_exists(public_path($path . $value->cover)) ? $path . $value->cover : '';
            })
            ->addColumn('select', function ($value) {
                return $value->book_id .'|'. $value->status;
            })
            ->addColumn('file_size', function ($value) {
                $path = $value->status != '1' && $value->status != '2' && $value->status != '5' ? 'books/' : 'tmp/books_tmp/';

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

            $book_folder = storage_path('app/private/books');
            $cover_folder = storage_path('app/public/covers');
            $btmp_folder = storage_path('app/private/tmp/books_tmp');
            $ctmp_folder = storage_path('app/public/tmp/covers_tmp');

            if (!File::exists($book_folder)) {
                File::makeDirectory($book_folder, 0777, true);
            }

            if (!File::exists($cover_folder)) {
                File::makeDirectory($cover_folder, 0777, true);
            }

            if (!File::exists($btmp_folder)) {
                File::makeDirectory($btmp_folder, 0777, true);
            }

            if (!File::exists($ctmp_folder)) {
                File::makeDirectory($ctmp_folder, 0777, true);
            }

            $file_pdf = '';
            if ($request->hasFile('file_pdf')) {
                try {
                    $file_pdf = $request->file('file_pdf')->getClientOriginalName();

                    $zipObj = new \ZipArchive();
                    $file = $zipObj->open($request->file('file_pdf')->path());
                    if ($file === TRUE) {
                        $logs->write('SUCCESS', 'OPEN '.$file_pdf);

                        if ($zipObj->extractTo($btmp_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME))) {
                            $zipObj->close();

                            $logs->write('SUCCESS', 'EXTRACT TO '.$btmp_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME));
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
                $path_pdf = $btmp_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME);

                $files = File::files($path_pdf);
                
                if (File::exists($path_pdf) && File::isDirectory($path_pdf)) {
                    foreach ($files as $key => $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                            $fileContent = Storage::size('tmp/books_tmp/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.basename($file));
                            $logs->write('info', $fileContent);

                            if ($fileContent > 20000000) {
                                $validSize = false;
                                $logs->write('failed', basename($file) . ' Ukuran File lebih dari 20mb.');
                                $results['error'][] = "Failed upload " . basename($file) . " Ukuran File lebih dari 20mb.";
                                break;
                            }
                        }
                    }

                    if (!$validSize) {
                        File::deleteDirectory($path_pdf);
                        return response()->json($results, $result['status']);
                    }
                }
            }

            if ($validSize) {
                $path_pdf = $btmp_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME);

                $files = File::files($path_pdf);

                $books = [];
                if (File::exists($path_pdf) && File::isDirectory($path_pdf)) {
                    foreach ($files as $key => $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                            $file_time = Carbon::now()->format('ymdHis');

                            $pdfPath = $btmp_folder.'/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.basename($file);
                            $pdf = new \Spatie\PdfToImage\Pdf($pdfPath);
                            $cover_name = $file_time.' '.pathinfo($file, PATHINFO_FILENAME).'.jpg';
                            $outputPath = $ctmp_folder.'/'.$cover_name;
                            $pdf->selectPage(1)->save($outputPath);
                            
                            $fileContent = Storage::get('tmp/books_tmp/'.pathinfo($file_pdf, PATHINFO_FILENAME).'/'.basename($file));

                            $encryptedContent = encrypt($fileContent);

                            $filename = $file_time.' '.pathinfo($file, PATHINFO_FILENAME);
                            $encryptFile = Storage::put('tmp/books_tmp/'.$filename.'.gns', $encryptedContent);

                            if ($encryptFile) {
                                $books_id = Str::uuid();
                                $upload = DB::table('tbook_draft')->insert([
                                        'book_id' => $books_id,
                                        'filename' => $filename . '.gns',
                                        'cover' => basename($outputPath),
                                        'status' => '1',
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
                            $results['error'][] = "Failed upload " . basename($file) . " Not PDF Extension.";
                        }
                    }
                }

                $data = DB::table('tbook_draft as a')->sharedLock()
                    ->select(
                        'a.book_id',
                        'a.filename',
                        'a.cover',
                        'a.category_id',
                        'a.publisher_id',
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
                        'path_cover' => file_exists(public_path('/storage/tmp/covers_tmp/'.$value->cover)) ? '/storage/tmp/covers_tmp/'.$value->cover : ''
                    ];
                });

                $results['data'] = $rslt;

                File::deleteDirectory($path_pdf);
            }

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

                case 'preview-data':
                    DB::enableQueryLog();

                    $books = [];
                    foreach (request()->data as $key => $value) {
                        $books[] = $value['book_id'];
                    }

                    $data = DB::table('tbook_draft as a')->sharedLock()
                        ->select(
                            'a.book_id as book_id',
                            'a.supplier_id as supplier_id',
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
                            'a.status as status'
                        )
                        ->join('tcompany_category as b', function($join) {
                            $join->on('a.supplier_id', '=', 'b.client_id') 
                                ->on('a.category_id', '=', 'b.category_id') ;
                        })
                        ->join('tpublisher as c', function($join) {
                            $join->on('a.supplier_id', '=', 'c.client_id') 
                                ->on('a.publisher_id', '=', 'c.id') ;
                        })
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
                                'publisher_desc' => $value->publisher_desc ?? '',
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
                                'category_desc' => $value->category_desc ?? '',
                                'book_format_id' => $value->book_format_id ?? '',
                                'filename' => $value->filename ?? '',
                                'cover' => $value->cover ?? '',
                                'age' => $value->age ?? '',
                                'status' => $value->status ?? '',
                                'path_cover' => file_exists(public_path('/storage/tmp/covers_tmp/'.$value->cover)) ? '/storage/tmp/covers_tmp/'.$value->cover : ''
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'selected-data':
                    DB::enableQueryLog();

                    $data = DB::table('tbook_draft as a')->sharedLock()
                        ->select(
                            'a.book_id',
                            'a.filename',
                            'a.cover',
                            'a.category_id',
                            'a.publisher_id',
                            'a.book_format_id'
                        )
                        ->whereIn('a.book_id', request()->data)
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
                                'filename' => $value->filename ?? '',
                                'cover' => $value->cover ?? '',
                                'category_id' => $value->category_id ?? '',
                                'publisher_id' => $value->publisher_id ?? '',
                                'book_format_id' => $value->book_format_id ?? '',
                                'path_cover' => file_exists(public_path('/storage/tmp/covers_tmp/'.$value->cover)) ? '/storage/tmp/covers_tmp/'.$value->cover : ''
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

            $updated = true;
            foreach ($request->all() as $key => $value) {
                if (is_array($value)) {
                    $updated = DB::table('tbook_draft')
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
                    ->where('supplier_id', auth()->user()->client_id)
                    ->where('book_id', $value['book_id'])
                    ->update([
                            'status' => '2',
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function submitReview(Request $request): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        $result['data'] = [];
        try {
            DB::enableQueryLog();
            
            $data['exists'] = $data['failed'] = [];
            $ii = 0;
            foreach ($request->all() as $key => $value) {
                if ( $value['book_id'] != '' && $value['filename'] != '' && $value['isbn'] != '' && $value['eisbn'] != '' && $value['title'] != '' && $value['writer'] != '' && $value['size'] != '' && $value['year'] != '' && $value['volume'] != '' && $value['edition'] != '' && $value['page'] != '' && $value['sinopsis'] != '' && $value['sellprice'] != '' && $value['rentprice'] != '' && $value['retailprice'] != '' && $value['city'] != '' && $value['age'] != '') {
                    $data['exists'][$key][$ii]['book_id'] = $value['book_id'];
                    $data['exists'][$key][$ii]['filename'] = $value['filename'];
                    $data['exists'][$key][$ii]['isbn'] = $value['isbn'];
                    $data['exists'][$key][$ii]['eisbn'] = $value['eisbn'];
                    $data['exists'][$key][$ii]['title'] = $value['title'];
                    $data['exists'][$key][$ii]['writer'] = $value['writer'];
                    $data['exists'][$key][$ii]['size'] = $value['size'];
                    $data['exists'][$key][$ii]['year'] = $value['year'];
                    $data['exists'][$key][$ii]['volume'] = $value['volume'];
                    $data['exists'][$key][$ii]['edition'] = $value['edition'];
                    $data['exists'][$key][$ii]['page'] = $value['page'];
                    $data['exists'][$key][$ii]['sinopsis'] = $value['sinopsis'];
                    $data['exists'][$key][$ii]['sellprice'] = $value['sellprice'];
                    $data['exists'][$key][$ii]['rentprice'] = $value['rentprice'];
                    $data['exists'][$key][$ii]['retailprice'] = $value['retailprice'];
                    $data['exists'][$key][$ii]['city'] = $value['city'];
                    $data['exists'][$key][$ii]['age'] = $value['age'];
                } else {
                    $data['failed'][$key][$ii]['row'] = $value['DT_RowIndex'];
                    $data['failed'][$key][$ii]['book_id'] = 'success|'.$value['book_id'];
                    $data['failed'][$key][$ii]['filename'] = 'success|'.$value['filename'];
                    $data['failed'][$key][$ii]['isbn'] = strlen($value['isbn']) < 9 ? 'error|Data ISBN minimal 9 karakter!' : ($value['isbn'] != '' ? 'success|'.$value['isbn'] : 'error|Data ISBN Kosong!');
                    $data['failed'][$key][$ii]['eisbn'] = $value['eisbn'] != '' ? 'success|'.$value['eisbn'] : 'error|Data EISBN Kosong!';
                    $data['failed'][$key][$ii]['title'] = $value['title'] != '' ? 'success|'.$value['title'] : 'error|Data Judul Kosong!';
                    $data['failed'][$key][$ii]['writer'] = $value['writer'] != '' ? 'success|'.$value['writer'] : 'error|Data Penulis Kosong!';
                    $data['failed'][$key][$ii]['size'] = $value['size'] != '' ? 'success|'.$value['size'] : 'error|Data Format Kosong!';
                    $data['failed'][$key][$ii]['year'] = $value['year'] != '' ? 'success|'.$value['year'] : 'error|Data Tahun Kosong!';
                    $data['failed'][$key][$ii]['volume'] = $value['volume'] != '' ? 'success|'.$value['volume'] : 'error|Data Jilid Kosong!';
                    $data['failed'][$key][$ii]['edition'] = $value['edition'] != '' ? 'success|'.$value['edition'] : 'error|Data Edisi Kosong!';
                    $data['failed'][$key][$ii]['page'] = $value['page'] != '' ? 'success|'.$value['page'] : 'error|Data Halaman Kosong!';
                    $data['failed'][$key][$ii]['sinopsis'] = $value['sinopsis'] != '' ? 'success|'.$value['sinopsis'] : 'error|Data Sinopsis Kosong!';
                    $data['failed'][$key][$ii]['sellprice'] = $value['sellprice'] != '' && is_numeric($value['sellprice']) ? 'success|'.$value['sellprice'] : 'error|Data Harga Jual Kosong atau bukan angka!';
                    $data['failed'][$key][$ii]['rentprice'] = $value['rentprice'] != '' && is_numeric($value['rentprice']) ? 'success|'.$value['rentprice'] : 'error|Data Harga Pinjam Kosong atau bukan angka!';
                    $data['failed'][$key][$ii]['retailprice'] = $value['retailprice'] != '' && is_numeric($value['retailprice']) ? 'success|'.$value['retailprice'] : 'error|Data Harga Retail Kosong atau bukan angka!';
                    $data['failed'][$key][$ii]['city'] = $value['city'] != '' ? 'success|'.$value['city'] : 'error|Data Kota Kosong!';
                    $data['failed'][$key][$ii]['age'] = $value['age'] != '' && is_numeric($value['age']) ? 'success|'.$value['age'] : 'error|Data Umur Kosong atau bukan angka!!';
                }

                $ii++;
            }

            $collect_failed_data = collect($data['failed'])->collapse()->all();

            if (!$collect_failed_data) {
                foreach ($request->all() as $key => $value) {
                    $updated = DB::table('tbook_draft')
                        ->where('supplier_id', auth()->user()->client_id)
                        ->where('book_id', $value['book_id'])
                        ->update([
                                'status' => '2',
                                'updatedate' => Carbon::now('Asia/Jakarta'),
                                'updateby' => auth()->user()->email,
                            ]);
                }

                if ($updated) {
                    $logs->write("INFO", "Successfully listing to Review");
    
                    $result['status'] = 201;
                    $result['message'] = "Successfully listing to Review.";
                }
            } else {
                $result['status'] = 422;
                $result['message'] = "Failed listing to Review : ". count($collect_failed_data) ." data";
                $result['data'] = $collect_failed_data;
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

        return response()->json(['message' => $result['message'], 'data' => $result['data']], $result['status']);
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
        $results['message'] = '';
        $results['data'] = [];

        $dataUpload  = json_decode($request['data'], true);

        $bookId = [];
        foreach ($dataUpload as $key => $value) {
            $bookId[$value['book_id']] = $value['book_id'];
        }

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

                $uploadID = [];
                for($row = 2; $row <= $highestRow; $row++) {
                    $book_uid = $worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue();
                    $uploadID[$book_uid] = $book_uid;
                }

                $missingIds = [];
                foreach ($bookId as $id) {
                    if (!array_key_exists($id, $uploadID)) {
                        $missingIds[] = $id;
                    }
                }

                if (!empty($missingIds)) {
                    foreach ($missingIds as $missingId) {
                        $tagging = 'failed';

                        $data_excel[$tagging][$i][$ii]['row'] = 0;
                        $data_excel[$tagging][$i][$ii]['book_id'] = 'error|Data Buku '.$missingId.' tidak ada di Excel!';
                        $data_excel[$tagging][$i][$ii]['filename'] = '';
                        $data_excel[$tagging][$i][$ii]['isbn'] = '';
                        $data_excel[$tagging][$i][$ii]['eisbn'] = '';
                        $data_excel[$tagging][$i][$ii]['title'] = '';
                        $data_excel[$tagging][$i][$ii]['writer'] = '';
                        $data_excel[$tagging][$i][$ii]['size'] = '';
                        $data_excel[$tagging][$i][$ii]['year'] = '';
                        $data_excel[$tagging][$i][$ii]['volume'] = '';
                        $data_excel[$tagging][$i][$ii]['edition'] = '';
                        $data_excel[$tagging][$i][$ii]['page'] = '';
                        $data_excel[$tagging][$i][$ii]['sinopsis'] = '';
                        $data_excel[$tagging][$i][$ii]['sellprice'] = '';
                        $data_excel[$tagging][$i][$ii]['rentprice'] = '';
                        $data_excel[$tagging][$i][$ii]['retailprice'] = '';
                        $data_excel[$tagging][$i][$ii]['city'] = '';
                        $data_excel[$tagging][$i][$ii]['age'] = '';

                        $ii++;
                    }
                } else {
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

                        if ($isbn != '' && strlen($isbn) >= 9 && $eisbn != '' && $title != '' && $writer != '' && $size != '' && $year != '' && $volume != '' && $edition != '' && $page != '' && $sinopsis != '' && $sellprice != '' && is_numeric($sellprice) && $rentprice != '' && is_numeric($rentprice) && $retailprice != '' && is_numeric($retailprice) && $city != '' && $age != '' && is_numeric($age) && array_key_exists($book_id, $bookId)) {
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

                            $data_excel[$tagging][$i][$ii]['row'] = $row;
                            $data_excel[$tagging][$i][$ii]['book_id'] = array_key_exists($book_id, $bookId) ? 'success|'.$book_id : 'error|Data Buku '.$book_id.' tidak ada list Update!';
                            $data_excel[$tagging][$i][$ii]['filename'] = 'success|'.$filename;
                            $data_excel[$tagging][$i][$ii]['isbn'] = strlen($isbn) < 9 ? 'error|Data ISBN minimal 9 karakter!' : ($isbn != '' ? 'success|'.$isbn : 'error|Data ISBN Kosong!');
                            $data_excel[$tagging][$i][$ii]['eisbn'] = $eisbn != '' ? 'success|'.$eisbn : 'error|Data EISBN Kosong!';
                            $data_excel[$tagging][$i][$ii]['title'] = $title != '' ? 'success|'.$title : 'error|Data Judul Kosong!';
                            $data_excel[$tagging][$i][$ii]['writer'] = $writer != '' ? 'success|'.$writer : 'error|Data Penulis Kosong!';
                            $data_excel[$tagging][$i][$ii]['size'] = $size != '' ? 'success|'.$size : 'error|Data Format Kosong!';
                            $data_excel[$tagging][$i][$ii]['year'] = $year != '' ? 'success|'.$year : 'error|Data Tahun Kosong!';
                            $data_excel[$tagging][$i][$ii]['volume'] = $volume != '' ? 'success|'.$volume : 'error|Data Jilid Kosong!';
                            $data_excel[$tagging][$i][$ii]['edition'] = $edition != '' ? 'success|'.$edition : 'error|Data Edisi Kosong!';
                            $data_excel[$tagging][$i][$ii]['page'] = $page != '' ? 'success|'.$page : 'error|Data Halaman Kosong!';
                            $data_excel[$tagging][$i][$ii]['sinopsis'] = $sinopsis != '' ? 'success|'.$sinopsis : 'error|Data Sinopsis Kosong!';
                            $data_excel[$tagging][$i][$ii]['sellprice'] = $sellprice != '' && is_numeric($sellprice) ? 'success|'.$sellprice : 'error|Data Harga Jual Kosong atau bukan angka!';
                            $data_excel[$tagging][$i][$ii]['rentprice'] = $rentprice != '' && is_numeric($rentprice) ? 'success|'.$rentprice : 'error|Data Harga Pinjam Kosong atau bukan angka!';
                            $data_excel[$tagging][$i][$ii]['retailprice'] = $retailprice != '' && is_numeric($retailprice) ? 'success|'.$retailprice : 'error|Data Harga Retail Kosong atau bukan angka!';
                            $data_excel[$tagging][$i][$ii]['city'] = $city != '' ? 'success|'.$city : 'error|Data Kota Kosong!';
                            $data_excel[$tagging][$i][$ii]['age'] = $age != '' && is_numeric($age) ? 'success|'.$age : 'error|Data Umur Kosong atau bukan angka!!';
                        }

                        $ii++;
                    }
                }
            }

            $logs->write('INFO', 'Worksheet Title: '. $worksheetTitle."\r\n");
        }

        try {
            DB::enableQueryLog();

            $collect_failed_data = collect($data_excel['failed'])->collapse()->all();

            if (!$collect_failed_data) {
                $collect_exists_data = collect($data_excel['exists'])->collapse()->all();
                $exists_count = 0;
                foreach ($collect_exists_data as $i => $value) {
                    $updated = DB::table('tbook_draft')
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

                $result['status'] = 201;
                $results['message'] .= "Successfully updated: ". $exists_count ." data";
                $results['data'] = [];
            } else {
                $result['status'] = 422;
                $results['message'] .= "Failed upload file: ". count($collect_failed_data) ." data";
                $results['data'] = $collect_failed_data;
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $results['message'] = "Failed upload file.<br>". $th->getMessage();
            $results['data'] = [];
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, $result['status']);
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
            $filePath = 'tmp/books_tmp/'.$request->file;
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
}
