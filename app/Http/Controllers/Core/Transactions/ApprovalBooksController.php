<?php

namespace App\Http\Controllers\Core\Transactions;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ApprovalBooksController extends Controller
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
                ->whereIn('a.supplier_id', $request->param)
                ->when(isset($status) && count($status) > 0, function($query) use ($status) {
                    $query->whereIn('a.status', $status);
                })
                ->whereNotIn('a.status', [1])
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
                return $value->sellprice ?? '';
            })
            ->editColumn('rentprice', function ($value) {
                return $value->rentprice ?? '';
            })
            ->editColumn('retailprice', function ($value) {
                return $value->retailprice ?? '';
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
                return file_exists(public_path($path . $value->cover)) ? $path . $value->cover : public_path($path . $value->cover);
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
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            foreach (request()->request->all() as $key => $value) {
                $draft = DB::table('tbook_draft as a')->sharedLock()
                        ->select(
                            'a.book_id as book_id',
                            'a.supplier_id as supplier_id',
                            'a.isbn as isbn',
                            'a.eisbn as eisbn',
                            'a.title as title',
                            'a.writer as writer',
                            'a.publisher_id as publisher_id',
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
                            'a.book_format_id as book_format_id',
                            'a.filename as filename',
                            'a.cover as cover',
                            'a.age as age'
                        )
                        ->where('book_id', $value)
                        ->first();

                $insert = DB::table('tbook')
                    ->updateOrInsert([
                        'book_id' => $draft->book_id,
                    ], [
                        'supplier_id' => $draft->supplier_id,
                        'isbn' => $draft->isbn,
                        'eisbn' => $draft->eisbn,
                        'title' => $draft->title,
                        'writer' => $draft->writer,
                        'publisher_id' => $draft->publisher_id,
                        'size' => $draft->size,
                        'year' => $draft->year,
                        'volume' => $draft->volume,
                        'edition' => $draft->edition,
                        'page' => $draft->page,
                        'sinopsis' => $draft->sinopsis,
                        'sellprice' => $draft->sellprice,
                        'rentprice' => $draft->rentprice,
                        'retailprice' => $draft->retailprice,
                        'city' => $draft->city,
                        'category_id' => $draft->category_id,
                        'book_format_id' => $draft->book_format_id,
                        'filename' => $draft->filename,
                        'cover' => $draft->cover,
                        'age' => $draft->age,
                        'createdate' => Carbon::now('Asia/Jakarta'),
                        'createby' => auth()->user()->email,
                        'updatedate' => Carbon::now('Asia/Jakarta'),
                        'updateby' => auth()->user()->email,
                    ]);

                if ($insert) {
                    $approve = DB::table('tbook_draft')
                    ->where('book_id', $value)
                    ->update([
                        'status' => '3',
                        'updatedate' => Carbon::now('Asia/Jakarta'),
                        'updateby' => auth()->user()->email
                    ]);

                    $data = DB::table('tbook_draft as a')->sharedLock()
                        ->select(
                            'a.filename as filename', 
                            'a.cover as cover'
                        )
                        ->where('book_id', $value)
                        ->first();

                    $scoverPath = public_path('storage/tmp/covers_tmp/'. $data->cover);
                    $dcoverPath = public_path('storage/covers/'. $data->cover);
                    
                    if (File::exists($scoverPath)) {
                        File::move($scoverPath, $dcoverPath);
                    }

                    $sfilePath = 'tmp/books_tmp/'. $data->filename;
                    $dfilePath = 'books/'. $data->filename;

                    if (Storage::exists($sfilePath)) {
                        Storage::move($sfilePath, $dfilePath);
                    }
                }
            }
            
            if ($approve) {
                $logs->write("INFO", "Successfully approve");

                $result['status'] = 201;
                $result['message'] = "Successfully approve.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed approve.<br>" . $th->getMessage();
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
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');

        if (request()->has('param') && request()->param != '') {
            switch (request()->param) {
                case 'supplier-mst':
                    DB::enableQueryLog();

                    $supplier = DB::table('users as a')->sharedLock()
                        ->select(
                            'a.client_id as id',
                            'b.name as name'
                        )
                        ->join('tcompany as b', function($join) {
							$join->on('a.client_id', '=', 'b.id') ;
						})
                        ->whereNotNull('email_verified_at')
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($supplier) {
                        $results = $supplier->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
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

            foreach (request()->request->all() as $key => $value) {
                $reject = DB::table('tbook_draft')
                    ->where('book_id', $value)
                    ->update([
                        'status' => '5',
                        'updatedate' => Carbon::now('Asia/Jakarta'),
                        'updateby' => auth()->user()->email
                    ]);
            }
            
            if ($reject) {
                $logs->write("INFO", "Successfully Reject");

                $result['status'] = 201;
                $result['message'] = "Successfully Reject.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed Reject.<br>" . $th->getMessage();
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
        return response()->json(['id' => $id], 200);
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewFile(Request $request)
    {
        if (Storage::exists('books/'. str_replace('&amp;', '&', $request->file))) {
            $filePath = 'books/'. str_replace('&amp;', '&', $request->file);
            $filename = explode('.', basename($filePath))[0];
        } else {
            $filePath = 'tmp/books_tmp/'. str_replace('&amp;', '&', $request->file);
            $filename = explode('.', basename($filePath))[0];
        }

        $encryptedContents = Storage::get($filePath);
        $decryptedContents = Crypt::decrypt($encryptedContents);
        return response()->make($decryptedContents, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'.pdf"'
        ]);
    }
}
