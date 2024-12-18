<?php

namespace App\Http\Controllers\Core\Transactions;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Exports\Transactions\UploadPOExport;
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
                    DB::raw('sum(c.sellprice) as po_amount'),
                    'a.po_discount as po_discount',
                    'a.persentase_supplier as persentase_supplier',
                    'a.status as status'
                )
                ->join('tclient as b', function($join) {
					$join->on('a.client_id', '=', 'b.client_id');
				})
                ->join('tpo_detail as c', function($join) {
					$join->on('a.client_id', '=', 'b.client_id');
				})
                ->groupBy(
                    'a.client_id',
                    'b.instansi_name',
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
                        ->when(isset($ponumber) && $ponumber != '', function($query) use ($ponumber) {
                            $query->where('a.po_number', $ponumber);
                        })
                        ->when(isset($podate) && $podate != '', function($query) use ($podate) {
                            $query->where('a.po_date', $podate);
                        })
                        ->when(isset($client) && $client != '', function($query) use ($client) {
                            $query->where('a.client_id', $client);
                        })
                        ->orderBy('b.name', 'asc')
                        ->orderBy('b.title', 'asc')
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
                    'status' => '2'
                ]);

            $logs->write("INFO", "Successfully updated");

            $result['status'] = 201;
            $result['message'] = "Successfully updated.";

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
        return response()->json(['id' => $id], 200);
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
        $data_excel['new'] = $data_excel['exists'] = [];
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
                $discPo     = $worksheet->getCellByColumnAndRow(2, 4)->getFormattedValue();
                $pctPo      = $worksheet->getCellByColumnAndRow(2, 5)->getFormattedValue();

                if ($clientId != '' && $noPo != '' && $tglPo != '' && $discPo != '' && $pctPo != '') {
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
    
                            $data_excel[$tagging][$i][$ii]['clientId']  = $clientId;
                            $data_excel[$tagging][$i][$ii]['noPo']      = $noPo;
                            $data_excel[$tagging][$i][$ii]['tglPo']     = $tglPo;
                            $data_excel[$tagging][$i][$ii]['discPo']    = $discPo;
                            $data_excel[$tagging][$i][$ii]['pctPo']     = $pctPo;
                            $data_excel[$tagging][$i][$ii]['bookId']    = $bookId;
                            $data_excel[$tagging][$i][$ii]['qty']       = $qty;
    
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
}
