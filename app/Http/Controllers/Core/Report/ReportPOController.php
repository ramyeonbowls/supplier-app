<?php

namespace App\Http\Controllers\Core\Report;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Exports\Report\ReportPO\ReportPOExport;
use App\Exports\Report\ReportPO\ReportPODetailExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class ReportPOController extends Controller
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

            $tbook = DB::table('tbook as a')->sharedLock()
                ->select(
                    'a.*',
                    'b.name'
                )
                ->join('tcompany as b', function($join) {
					$join->on('a.supplier_id', '=', 'b.id')
                        ->on('b.type', '=', DB::raw("'1'"));
				});

            $detail = DB::table('tpo_detail as a')->sharedLock()
                ->select(
                    'a.client_id as client_id',
                    'a.po_number as po_number',
                    'a.po_date as po_date',
                    'b.supplier_id as supplier_id',
                    'b.name as supplier_name',
                    'a.book_id as book_id',
                    'a.qty as qty',
                    'a.sellprice as sellprice'
                )
                ->joinSub($tbook, 'b', function($join) {
                    $join->on('a.book_id', '=', 'b.book_id');
                });

            $results = DB::table('tpo_header as a')->sharedLock()
                ->select(
                    'a.client_id as client_id',
                    'b.instansi_name as client_name',
                    'c.supplier_id as supplier_id',
                    'c.supplier_name as supplier_name',
                    'a.po_number as po_number',
                    'a.po_date as po_date',
                    'a.po_type as po_type',
                    DB::raw('sum(c.sellprice) as po_amount'),
                    'a.po_discount as po_discount',
                    'a.persentase_supplier as persentase_supplier',
                    'a.status as status',
                )
                ->join('tclient as b', function($join) {
					$join->on('a.client_id', '=', 'b.client_id');
				})
                ->joinSub($detail, 'c', function($join) {
					$join->on('a.client_id', '=', 'c.client_id')
                        ->on('a.po_number', '=', 'c.po_number')
                        ->on('a.po_date', '=', 'c.po_date');
				})
                // ->where('c.supplier_id', auth()->user()->client_id)
                // ->whereIn('a.status', ['3', '4'])
                ->groupBy(
                    'a.client_id',
                    'b.instansi_name',
                    'c.supplier_id',
                    'c.supplier_name',
                    'a.po_number',
                    'a.po_date',
                    'a.po_type',
                    'a.po_discount',
                    'a.persentase_supplier',
                    'a.status'
                )
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
            ->editColumn('po_amount', function ($value) {
                return number_format($value->po_amount, 0, 2) ?? 0;
            })
            ->addColumn('po_nett', function ($value) {
                $nett = ($value->persentase_supplier != 0) ? $value->po_amount * ($value->persentase_supplier / 100) : $value->po_amount;
                return number_format($nett, 0, ",", ".");
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
        return response()->json(['request' => $request], 200);
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
                case 'detail-po':
                    DB::enableQueryLog();

                    $supplier = request()->supplier ?? '';
                    $ponumber = request()->ponumber ?? '';
                    $podate = request()->podate ?? '';
                    $client = request()->client ?? '';

                    $tbook = DB::table('tbook as a')->sharedLock()
                        ->select(
                            'a.*',
                            'b.name',
                            'c.description as publisher_desc'
                        )
                        ->join('tcompany as b', function($join) {
                            $join->on('a.supplier_id', '=', 'b.id')
                                ->on('b.type', '=', DB::raw("'1'"));
                        })
                        ->leftJoin('tpublisher as c', function($join) {
                            $join->on('a.supplier_id', '=', 'c.client_id') 
                                ->on('a.publisher_id', '=', 'c.id') ;
                        });

                    $detail = DB::table('tpo_header as a')->sharedLock()
                        ->select(
                            'a.client_id as client_id',
                            'a.po_number as po_number',
                            'a.po_date as po_date',
                            'c.supplier_id as supplier_id',
                            'c.name as supplier_name',
                            'b.book_id as book_id',
                            'c.title as book_name',
                            'b.qty as qty',
                            'b.sellprice as sellprice',
                            'c.cover as cover',
                            'c.isbn as isbn',
                            'c.writer as writer',
                            'c.publisher_id as publisher_id',
                            'c.publisher_desc as publisher_desc',
                            'a.persentase_supplier as persentase_supplier'
                        )
                        ->join('tpo_detail as b', function($join) {
                            $join->on('a.client_id', '=', 'b.client_id')
                                ->on('a.po_number', '=', 'b.po_number')
                                ->on('a.po_date', '=', 'b.po_date');
                        })
                        ->joinSub($tbook, 'c', function($join) {
                            $join->on('b.book_id', '=', 'c.book_id');
                        })
                        ->when(isset($supplier) && $supplier != '', function($query) use ($supplier) {
                            $query->where('c.supplier_id', $supplier);
                        })
                        ->when(isset($ponumber) && $ponumber != '', function($query) use ($ponumber) {
                            $query->where('a.po_number', $ponumber);
                        })
                        ->when(isset($podate) && $podate != '', function($query) use ($podate) {
                            $query->where('a.po_date', $podate);
                        })
                        ->when(isset($client) && $client != '', function($query) use ($client) {
                            $query->where('a.client_id', $client);
                        })
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if ($detail) {
                        $results = $detail->map(function($value, $key) {
                            $total_gross = $value->sellprice * $value->qty;
                            $total_nett = ($value->persentase_supplier != 0) ? ($value->sellprice * $value->qty) * ($value->persentase_supplier / 100) : ($value->sellprice * $value->qty);
                            $nett = ($value->persentase_supplier != 0) ? $value->sellprice * ($value->persentase_supplier / 100) : $value->sellprice;

                            return [
                                'cover' => file_exists(public_path('storage/covers/' . $value->cover)) ? 'storage/covers/' . $value->cover : '',
                                'client_id' => $value->client_id,
                                'po_number' => $value->po_number,
                                'po_date' => $value->po_date,
                                'supplier_id' => $value->supplier_id,
                                'supplier_name' => $value->supplier_name,
                                'book_id' => $value->book_id,
                                'book_name' => $value->book_name,
                                'qty' => $value->qty,
                                'sellprice' => number_format($value->sellprice, 0, 2),
                                'isbn' => $value->isbn,
                                'writer' => $value->writer,
                                'publisher_id' => $value->publisher_id,
                                'publisher_desc' => $value->publisher_desc,
                                'nett' => number_format($nett, 0, 2),
                                'total_gross' => number_format($total_gross, 0, 2),
                                'total_nett' => number_format($total_nett, 0, 2),
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
        return response()->json(['request' => $request, 'id' => $id], 200);
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
    public function exportTpl(Request $request): BinaryFileResponse
    {
        return Excel::download(new ReportPOExport(), 'laporan_penjualan_supplier.xlsx');
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportTplDetail(Request $request): BinaryFileResponse
    {
        return Excel::download(new ReportPODetailExport($request->data), 'laporan_penjualan_supplier.xlsx');
    }
}
