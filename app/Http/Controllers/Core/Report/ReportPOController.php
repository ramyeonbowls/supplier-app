<?php

namespace App\Http\Controllers\Core\Report;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
                        ->on('b.type', '=', '1');
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
                ->where('c.supplier_id', auth()->user()->client_id)
                ->whereNot('a.status', '1')
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
                            'b.name'
                        )
                        ->join('tcompany as b', function($join) {
                            $join->on('a.supplier_id', '=', 'b.id')
                                ->on('b.type', '=', '1');
                        });

                    $detail = DB::table('tpo_detail as a')->sharedLock()
                        ->select(
                            'a.client_id as client_id',
                            'a.po_number as po_number',
                            'a.po_date as po_date',
                            'b.supplier_id as supplier_id',
                            'b.name as supplier_name',
                            'a.book_id as book_id',
                            'b.title as book_name',
                            'a.qty as qty',
                            'a.sellprice as sellprice'
                        )
                        ->joinSub($tbook, 'b', function($join) {
                            $join->on('a.book_id', '=', 'b.book_id');
                        })
                        ->when(isset($supplier) && $supplier != '', function($query) use ($supplier) {
                            $query->where('b.supplier_id', $supplier);
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
                            return [
                                'client_id' => $value->client_id,
                                'po_number' => $value->po_number,
                                'po_date' => $value->po_date,
                                'supplier_id' => $value->supplier_id,
                                'supplier_name' => $value->supplier_name,
                                'book_id' => $value->book_id,
                                'book_name' => $value->book_name,
                                'qty' => $value->qty,
                                'sellprice' => number_format($value->sellprice, 0, 2),
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
}
