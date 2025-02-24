<?php

namespace App\Http\Controllers\Core\Transactions;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Exports\Transactions\UploadPOExport;
use App\Exports\Transactions\UploadPODetailExport;
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

class UploadPurchaseOrderController extends Controller
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

        if ($request->date) {
            $filter['sdate'] = explode(' to ', $request->date)[0] ?? $request->date;
            $filter['edate'] = explode(' to ', $request->date)[1] ?? $request->date;
        } else {
            $filter['sdate'] = '';
            $filter['edate'] = '';
        }

        $filter['client'] = $request->client ?? '';

        $results = [];
        try {
            DB::enableQueryLog();

            $results = DB::table('tpo_header as a')->sharedLock()
                ->select(
                    'a.client_id as client_id',
                    'b.instansi_name as client_name',
                    'a.po_number as po_number',
                    'a.po_date as po_date',
                    'a.po_type as po_type',
                    DB::raw('sum(c.sellprice * c.qty) as po_amount'),
                    'a.po_discount as po_discount',
                    'a.persentase_supplier as persentase_supplier',
                    'a.status as status',
                    'a.distributor_id as distributor_id',
                    'd.name as distributor_name',
                )
                ->join('tclient as b', function($join) {
					$join->on('a.client_id', '=', 'b.client_id');
				})
                ->join('tpo_detail as c', function($join) {
					$join->on('a.client_id', '=', 'c.client_id')
                        ->on('a.po_number', '=', 'c.po_number')
                        ->on('a.po_date', '=', 'c.po_date');
				})
                ->LeftJoin('tcompany as d', function($join) {
					$join->on('a.distributor_id', '=', 'd.id');
				})
                ->when(isset($filter['sdate']) && $filter['sdate'] != '' && isset($filter['edate']) && $filter['edate'] != '', function($query) use ($filter) {
                    $query->whereBetween('a.po_date', [$filter['sdate'], $filter['edate']]);
                })
                ->when(isset($filter['client']) && $filter['client'] != '', function($query) use ($filter) {
                    $query->where('a.client_id', $filter['client']);
                })
                ->when(auth()->user()->role == 2, function($query) {
                    $query->where('a.distributor_id', auth()->user()->client_id);
                })
                ->groupBy(
                    'a.client_id',
                    'b.instansi_name',
                    'a.po_number',
                    'a.po_date',
                    'a.po_type',
                    'a.po_discount',
                    'a.persentase_supplier',
                    'a.status',
                    'a.distributor_id',
                    'd.name'
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
                return number_format($value->po_amount, 0, ",", ".") ?? 0;
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
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            $param = $request->params['param'] == 'distributor' ? [ 'distributor_id' => $request->params['distributor_id'] ] : [ 'po_type' => $request->params['po_type'] ];

            $updated = DB::table('tpo_header')
                ->where('client_id', $request->params['client_id'])
                ->where('po_number', $request->params['po_number'])
                ->where('po_date', $request->params['po_date'])
                ->update($param);

            if ($updated) {
                $logs->write("INFO", "Successfully updated");
                $result['status'] = 201;
                $result['message'] = "Successfully updated.";
            } else {
                $result['status'] = 500;
                $result['message'] = "Failed updated.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['status'] = 500;
            $result['message'] = "Failed updated.<br>" . $th->getMessage();
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

                case 'detail-po-supplier':
                    DB::enableQueryLog();

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
                            'a.sellprice as sellprice',
                        )
                        ->joinSub($tbook, 'b', function($join) {
                            $join->on('a.book_id', '=', 'b.book_id');
                        });

                    $detailPo = DB::table('tpo_header as a')->sharedLock()
                        ->select(
                            'a.client_id as client_id',
                            'b.instansi_name as client_name',
                            'c.supplier_id as supplier_id',
                            'c.supplier_name as supplier_name',
                            'a.po_number as po_number',
                            'a.po_date as po_date',
                            'a.po_type as po_type',
                            DB::raw('sum(c.sellprice * c.qty) as po_amount'),
                            'a.po_discount as po_discount',
                            'a.persentase_supplier as persentase_supplier',
                        )
                        ->join('tclient as b', function($join) {
                            $join->on('a.client_id', '=', 'b.client_id');
                        })
                        ->joinSub($detail, 'c', function($join) {
                            $join->on('a.client_id', '=', 'c.client_id')
                                ->on('a.po_number', '=', 'c.po_number')
                                ->on('a.po_date', '=', 'c.po_date');
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
                        ->groupBy(
                            'a.client_id',
                            'b.instansi_name',
                            'c.supplier_id',
                            'c.supplier_name',
                            'a.po_number',
                            'a.po_date',
                            'a.po_type',
                            'a.po_discount',
                            'a.persentase_supplier'
                        )
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if ($detailPo) {
                        $results = $detailPo->map(function($value, $key) {
                            $nett = ($value->persentase_supplier != 0) ? $value->po_amount * ($value->persentase_supplier / 100) : $value->po_amount;

                            return [
                                'client_id' => $value->client_id,
                                'client_name' => $value->client_name,
                                'supplier_id' => $value->supplier_id,
                                'supplier_name' => $value->supplier_name,
                                'po_number' => $value->po_number,
                                'po_date' => $value->po_date,
                                'po_type' => $value->po_type,
                                'po_amount' => number_format($value->po_amount, 0, 2) ?? 0,
                                'po_discount' => $value->po_discount,
                                'persentase_supplier' => $value->persentase_supplier,
                                'po_nett' => number_format($nett, 0, ",", "."),
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'client-mst':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tclient as a')->sharedLock()
                        ->select(
                            'a.client_id as id',
                            'a.instansi_name as name'
                        )
                        ->where('a.flag_appr', 'Y')
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

                case 'distributor-mst':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tcompany as a')->sharedLock()
                        ->select(
                            'a.id as id',
                            'a.name as name'
                        )
                        ->join('users as b', function($join) {
                            $join->on('a.id', '=', 'b.client_id');
                        })
                        ->where('b.status', 1)
                        ->where('a.type', '2')
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

            $updated = DB::table('tpo_header')
                ->where('client_id', $request->client_id)
                ->where('po_number', $request->po_number)
                ->where('po_date', $request->po_date)
                ->update([
                    'status' => $id
                ]);

            if ($updated) {
                $logs->write("INFO", "Successfully updated");
                $result['status'] = 201;
                $result['message'] = "Successfully updated.";

                if ($id == '2') {
                    $detailMap = DB::table('tpo_detail as a')->sharedLock()
                        ->select(
                            'a.client_id as client_id',
                            'a.po_number as po_number',
                            'a.book_id as book_id',
                            'a.qty as qty'
                        )
                        ->where('a.client_id', $request->client_id)
                        ->where('a.po_number', $request->po_number)
                        ->where('a.po_date', $request->po_date)
                        ->distinct()
                        ->get();

                    foreach ($detailMap as $i => $value) {
                        $mapping = DB::table('tmapping_book')->insert([
                            'client_id' => $value->client_id,
                            'po_number' => $value->po_number,
                            'book_id' => $value->book_id,
                            'copy' => $value->qty,
                            'created_at' => Carbon::now('Asia/Jakarta'),
                            'updated_at' => Carbon::now('Asia/Jakarta'),
                        ]);
                    }                    
                }

                if ($id == '3') {
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
                            'b.supplier_id as supplier_id',
                        )
                        ->joinSub($tbook, 'b', function($join) {
                            $join->on('a.book_id', '=', 'b.book_id');
                        })
                        ->where('a.client_id', $request->client_id)
                        ->where('a.po_number', $request->po_number)
                        ->where('a.po_date', $request->po_date)
                        ->distinct()
                        ->get();

                    foreach ($detail as $i => $value) {
                        $paid = DB::table('tpo_paid_off')->insert([
                            'supplier_id' => $value->supplier_id,
                            'client_id' => $request->client_id,
                            'po_number' => $request->po_number,
                            'po_date' => $request->po_date,
                            'payment_image' => '',
                            'created_at' => Carbon::now('Asia/Jakarta'),
                            'created_by' => auth()->user()->email,
                        ]);
                    }
                }
            } else {
                $result['status'] = 500;
                $result['message'] = "Failed updated.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['status'] = 500;
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
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $filter['po_number'] = explode('|', $id)[0] ?? '';
        $filter['client_id'] = explode('|', $id)[1] ?? '';
        $filter['po_date'] = explode('|', $id)[2] ?? '';

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            $deleted = DB::table('tmapping_book')
                ->where('client_id', $filter['client_id'])
                ->where('po_number', $filter['po_number'])
                ->delete();

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }

            if ($deleted) {
                $logs->write("INFO", "PO berhasil ditarik");
                $result['message'] = 'PO berhasil ditarik';

                $updated = DB::table('tpo_header')
                    ->where('client_id', $filter['client_id'])
                    ->where('po_number', $filter['po_number'])
                    ->where('po_date', $filter['po_date'])
                    ->update([
                        'status' => '5'
                    ]);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = 'PO gagal ditarik.<br>' . $th->getMessage();
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
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
        $result['message'] = [];

        $spreadsheet = IOFactory::load($request['file_master']);
        $sheetCount  = $spreadsheet->getSheetCount();

        $logs->write('INFO', 'sheetCount:'. $sheetCount);
        $data_excel['new'] = $data_excel['exists'] = $data_excel['notexists'] = [];
        foreach ($spreadsheet->getWorksheetIterator() as $i => $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $worksheetTitle_A   = explode(" ", $worksheetTitle);

            $logs->write('INFO', 'Worksheet Title: '. $worksheetTitle);
            $logs->write('INFO', 'Total row: '. ($highestRow - 1));
            if ($worksheetTitle_A[0] == 'DATA') {
                $ii = 0;

                $clientId   = $worksheet->getCellByColumnAndRow(2, 1)->getFormattedValue();
                $noPo       = $worksheet->getCellByColumnAndRow(2, 2)->getFormattedValue();
                $tglPo      = $worksheet->getCellByColumnAndRow(2, 3)->getFormattedValue();
                $discPo     = 0;
                $pctPo      = $worksheet->getCellByColumnAndRow(2, 4)->getFormattedValue();

                if ($clientId != '' && $noPo != '' && $tglPo != '' && $discPo != '' && $pctPo != '') {
                    $distributor = DB::table('tcompany as a')->select('a.company_id as distributor_id')->sharedLock()->where('a.client_id', $clientId)->first();

                    for ($row = 8; $row <= $highestRow; $row++) {
                        $bookId     = $worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue();
                        $qty        = $worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue();
    
                        if ($bookId != '' && $qty != '') {
                            $exists = DB::table('tpo_header')->sharedLock()->where('po_number', $noPo)->first('po_number');
                            $status = DB::table('tpo_header')->sharedLock()->where('po_number', $noPo)->first('status');
    
                            $tagging = 'new';
                            if ($exists) {
                                $tagging = $status->status == '1' ? 'exists' : 'notexists';
                            }
    
                            $data_excel[$tagging][$i][$ii]['clientId']         = $clientId;
                            $data_excel[$tagging][$i][$ii]['noPo']             = $noPo;
                            $data_excel[$tagging][$i][$ii]['tglPo']            = $tglPo;
                            $data_excel[$tagging][$i][$ii]['discPo']           = $discPo;
                            $data_excel[$tagging][$i][$ii]['pctPo']            = $pctPo;
                            $data_excel[$tagging][$i][$ii]['bookId']           = $bookId;
                            $data_excel[$tagging][$i][$ii]['qty']              = $qty;
                            $data_excel[$tagging][$i][$ii]['distributorId']    = $distributor->distributor_id;
    
                            $ii++;
                        }
                    }  
                }
            }
            $logs->write('INFO', 'Worksheet Title: '. $worksheetTitle."\r\n");
        }

        try {
            DB::enableQueryLog();

            $collect_exists_data = collect($data_excel['exists'])->collapse()->all();
            if (count($collect_exists_data) > 0) {
                $deleteHdr = DB::table('tpo_header')->whereIn('po_number', collect($collect_exists_data)->pluck('noPo')->unique()->values()->all())->delete();
                $deleteDtl = DB::table('tpo_detail')->whereIn('po_number', collect($collect_exists_data)->pluck('noPo')->unique()->values()->all())->delete();

                if ($deleteHdr && $deleteDtl) {
                    foreach ($collect_exists_data as $i => $value) {
                        $book = DB::table('tbook')->sharedLock()->where('book_id', $value['bookId'])->first();

                        if ($book) {
                            $insertHdr = DB::table('tpo_header')
                                ->updateOrInsert([
                                    'po_number' => $value['noPo'],
                                ], [
                                    'client_id' => $value['clientId'],
                                    'po_number' => $value['noPo'],
                                    'po_date' => $value['tglPo'],
                                    'po_type' => '1',
                                    'po_amount' => 0,
                                    'po_discount' => $value['discPo'],
                                    'status' => '1',
                                    'persentase_supplier' => $value['pctPo'],
                                    'distributor_id' => $value['distributorId'],
                                    'created_at' => Carbon::now('Asia/Jakarta'),
                                    'created_by' => auth()->user()->email,
                                ]);
        
                            $insertDtl = DB::table('tpo_detail')
                                ->updateOrInsert([
                                    'po_number' => $value['noPo'],
                                    'client_id' => $value['clientId'],
                                    'po_number' => $value['noPo'],
                                    'po_date' => $value['tglPo'],
                                    'book_id' => $book->book_id,
                                ], [
                                    'qty' => $value['qty'],
                                    'sellprice' => $book->sellprice,
                                    'created_at' => Carbon::now('Asia/Jakarta'),
                                    'created_by' => auth()->user()->email,
                                ]);
                        } else {
                            $result['message'][] = "Buku dengan ID ". $value['bookId'] ." tidak ada";
                        }
                    }
                }
            }

            $collect_new_data = collect($data_excel['new'])->collapse()->all();
            foreach ($collect_new_data as $i => $value) {
                $book = DB::table('tbook')->sharedLock()->where('book_id', $value['bookId'])->first();

                if ($book) {
                    $insertHdr = DB::table('tpo_header')
                        ->updateOrInsert([
                            'po_number' => $value['noPo'],
                        ], [
                            'client_id' => $value['clientId'],
                            'po_number' => $value['noPo'],
                            'po_date' => $value['tglPo'],
                            'po_type' => '1',
                            'po_amount' => 0,
                            'po_discount' => $value['discPo'],
                            'status' => '1',
                            'persentase_supplier' => $value['pctPo'],
                            'distributor_id' => $value['distributorId'],
                            'created_at' => Carbon::now('Asia/Jakarta'),
                            'created_by' => auth()->user()->email,
                        ]);

                    $insertDtl = DB::table('tpo_detail')
                        ->updateOrInsert([
                            'client_id' => $value['clientId'],
                            'po_number' => $value['noPo'],
                            'po_date' => $value['tglPo'],
                            'book_id' => $book->book_id,
                        ], [
                            'qty' => $value['qty'],
                            'sellprice' => $book->sellprice,
                            'created_at' => Carbon::now('Asia/Jakarta'),
                            'created_by' => auth()->user()->email,
                        ]);
                } else {
                    $result['message'][] = "Buku dengan ID ". $value['bookId'] ." tidak ada";
                }
            }

            $collect_notexists_data = collect($data_excel['notexists'])->collapse()->all();
            $notexists_data = collect($collect_notexists_data)->pluck('noPo')->unique()->values()->all();
            foreach ($notexists_data as $i => $value) {
                $result['message'][] = "Statu No. PO ". $value ." tidak open";
            }

            $result['status'] = 201;
            $result['message'][] = "Successfully uploaded PO";

            $queries = DB::getQueryLog();
            for($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'][] = "Failed upload file.<br>". $th->getMessage();
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result, $result['status']);
    }
    
    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportTpl(Request $request): BinaryFileResponse
    {
        return Excel::download(new UploadPOExport(), 'upload_data_po.xlsx');
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportTplDetail(Request $request): BinaryFileResponse
    {
        return Excel::download(new UploadPODetailExport($request->data), 'laporan_po_supplier.xlsx');
    }
}
