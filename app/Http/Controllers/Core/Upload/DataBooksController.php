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

        return DataTables::of($results)
            ->escapeColumns([])
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $id): JsonResponse
    {
        //
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
}
