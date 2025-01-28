<?php

namespace App\Http\Controllers\Core\Profile;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileCompanyRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProfileCompanyController extends Controller
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

            $results = DB::table('tcompany as a')->sharedLock()
                ->select(
                    'a.id as id',
                    'a.name as name',
                    'a.email as email',
                    'a.country as country',
                    'a.province as province',
                    'b.provinsi_name as province_name',
                    'a.regency as regency',
                    'c.kabupaten_name as regency_name',
                    'a.district as district',
                    'd.kecamatan_name as district_name',
                    'a.subdistrict as subdistrict',
                    'e.kelurahan_name as subdistrict_name',
                    'a.postal_code as postal_code',
                    'a.address as address',
                    'a.telephone as telephone',
                    'a.handphone as handphone',
                    'a.director as director',
                    'a.position as position',
                    'a.handphone_director as handphone_director',
                    'a.pic as pic',
                    'a.handphone_pic as handphone_pic',
                    'a.file as file',
                    'a.agreement as agreement',
                    'a.type as type',
                    'a.documents as documents',
                    'a.created_at as created_at',
                    'a.created_by as created_by',
                    'a.updated_at as updated_at',
                    'a.updated_by as updated_by',
                )
                ->join('tprovinsi as b', function($join) {
					$join->on('a.province', '=', 'b.provinsi_id');
				})
                ->join('tkabupaten as c', function($join) {
					$join->on('a.province', '=', 'c.provinsi_id')
                        ->on('a.regency', '=', 'c.kabupaten_id');
				})
                ->join('tkecamatan as d', function($join) {
					$join->on('a.province', '=', 'd.provinsi_id')
                        ->on('a.regency', '=', 'd.kabupaten_id')
                        ->on('a.district', '=', 'd.kecamatan_id');
				})
                ->join('tkelurahan as e', function($join) {
					$join->on('a.province', '=', 'e.provinsi_id')
                        ->on('a.regency', '=', 'e.kabupaten_id')
                        ->on('a.district', '=', 'e.kecamatan_id')
                        ->on('a.subdistrict', '=', 'e.kelurahan_id');
				})
                ->where('a.id', auth()->user()->client_id)
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
            ->escapeColumns()
            ->editColumn('created_at', function ($value) {
                return Carbon::parse($value->created_at)->toDateTimeString();
            })
            ->editColumn('updated_at', function ($value) {
                return Carbon::parse($value->updated_at)->toDateTimeString();
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
        return response()->json(['store' => 'store'], 200);
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
                case 'provinsi-mst':
                    DB::enableQueryLog();

                    $provinsi = DB::table('tprovinsi as a')->sharedLock()
                        ->select(
                            'a.provinsi_id as id',
                            'a.provinsi_name as name'
                        )
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($provinsi) {
                        $results = $provinsi->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kabupaten-mst':
                    DB::enableQueryLog();

                    $provinsi = request()->provinsi ?? '';
                    $kabupaten = DB::table('tkabupaten as a')->sharedLock()
                        ->select(
                            'a.kabupaten_id as id',
                            'a.kabupaten_name as name'
                        )
                        ->when(isset($provinsi) && $provinsi != '', function($query) use ($provinsi) {
                            $query->where('a.provinsi_id', $provinsi);
                        })
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($kabupaten) {
                        $results = $kabupaten->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kecamatan-mst':
                    DB::enableQueryLog();

                    $provinsi = request()->provinsi ?? '';
                    $kabupaten = request()->kabupaten ?? '';
                    $kecamatan = DB::table('tkecamatan as a')->sharedLock()
                        ->select(
                            'a.kecamatan_id as id',
                            'a.kecamatan_name as name'
                        )
                        ->when(isset($provinsi) && $provinsi != '', function($query) use ($provinsi) {
                            $query->where('a.provinsi_id', $provinsi);
                        })
                        ->when(isset($kabupaten) && $kabupaten != '', function($query) use ($kabupaten) {
                            $query->where('a.kabupaten_id', $kabupaten);
                        })
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($kecamatan) {
                        $results = $kecamatan->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kelurahan-mst':
                    DB::enableQueryLog();

                    $provinsi = request()->provinsi ?? '';
                    $kabupaten = request()->kabupaten ?? '';
                    $kecamatan = request()->kecamatan ?? '';
                    $kelurahan = DB::table('tkelurahan as a')->sharedLock()
                        ->select(
                            'a.kelurahan_id as id',
                            'a.kelurahan_name as name'
                        )
                        ->when(isset($provinsi) && $provinsi != '', function($query) use ($provinsi) {
                            $query->where('a.provinsi_id', $provinsi);
                        })
                        ->when(isset($kabupaten) && $kabupaten != '', function($query) use ($kabupaten) {
                            $query->where('a.kabupaten_id', $kabupaten);
                        })
                        ->when(isset($kecamatan) && $kecamatan != '', function($query) use ($kecamatan) {
                            $query->where('a.kecamatan_id', $kecamatan);
                        })
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($kelurahan) {
                        $results = $kelurahan->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kategori-mst':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tbook_category as a')->sharedLock()
                        ->select(
                            'a.id as id',
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

                case 'imprint-profile':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tpublisher as a')->sharedLock()
                        ->select(
                            'a.id as id',
                            'a.description as name'
                        )
                        ->where('a.client_id', auth()->user()->client_id)
                        ->where('a.flag', 'I')
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

                case 'publisher-profile':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tpublisher as a')->sharedLock()
                        ->select(
                            'a.id as id',
                            'a.description as name'
                        )
                        ->where('client_id', auth()->user()->client_id)
                        ->where('a.flag', 'K')
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

                case 'category-profile':
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
                                'desc' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'account-profile':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tcompany_bank_account as a')->sharedLock()
                        ->select(
                            'a.npwp as npwp',
                            'a.account_bank as account_bank',
                            'a.bank as bank',
                            'a.account_name as account_name',
                            'a.bank_city as bank_city'
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
                                'npwp' => $value->npwp,
                                'account_bank' => $value->account_bank,
                                'bank' => $value->bank,
                                'account_name' => $value->account_name,
                                'bank_city' => $value->bank_city,
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'dashboard-admin':
                    DB::enableQueryLog();

                    $books = DB::table('tbook as a')->count();
                    $client = DB::table('tclient as a')->where('a.flag_appr', 'Y')->count();
                    $supplier = DB::table('tcompany as a')->where('a.type', '1')->count();
                    $distributor = DB::table('tcompany as a')->where('a.type', '2')->count();
                    $review = DB::table('tbook_draft as a')->where('a.status', '2')->count();
                    $reject = DB::table('tbook_draft as a')->where('a.status', '5')->count();
                    $pending = DB::table('tbook_draft as a')->where('a.status', '4')->count();
                    $publisher = DB::table('tpublisher as a')->count();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results['books'] = $books;
                    $results['client'] = $client;
                    $results['supplier'] = $supplier;
                    $results['distributor'] = $distributor;
                    $results['review'] = $review;
                    $results['reject'] = $reject;
                    $results['pending'] = $pending;
                    $results['publisher'] = $publisher;

                    return response()->json($results, 200);
                break;

                case 'dashboard-admin-1':
                    DB::enableQueryLog();

                    $filters = request()->periode ?? Carbon::now('Asia/Jakarta')->format('Y');

                    $months = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember'
                    ];

                    $totals = DB::table('tbook_draft as a')->where('a.createdate', 'like', $filters . '%')->count();

                    $total = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $total[$months[$i]] = DB::table('tbook_draft as a')
                            ->where('a.createdate', 'like', $filters . '-' . $month . '%')
                            ->count();
                    }

                    $publish = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $publish[$months[$i]] = DB::table('tbook_draft as a')
                            ->where('a.createdate', 'like', $filters . '-' . $month . '%')
                            ->where('a.status', '3')
                            ->count();
                    }

                    $review = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $review[$months[$i]] = DB::table('tbook_draft as a')
                            ->where('a.createdate', 'like', $filters . '-' . $month . '%')
                            ->where('a.status', '2')
                            ->count();
                    }

                    $draft = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $draft[$months[$i]] = DB::table('tbook_draft as a')
                            ->where('a.createdate', 'like', $filters . '-' . $month . '%')
                            ->where('a.status', '1')
                            ->count();
                    }

                    $pending = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $pending[$months[$i]] = DB::table('tbook_draft as a')
                            ->where('a.createdate', 'like', $filters . '-' . $month . '%')
                            ->where('a.status', '4')
                            ->count();
                    }

                    $reject = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $reject[$months[$i]] = DB::table('tbook_draft as a')
                            ->where('a.createdate', 'like', $filters . '-' . $month . '%')
                            ->where('a.status', '5')
                            ->count();
                    }

                    $withdrawn = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $withdrawn[$months[$i]] = DB::table('tbook_draft as a')
                            ->where('a.createdate', 'like', $filters . '-' . $month . '%')
                            ->where('a.status', '6')
                            ->count();
                    }

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results['totals'] = $totals;
                    $results['total'] = $total;
                    $results['publish'] = $publish;
                    $results['review'] = $review;
                    $results['draft'] = $draft;
                    $results['pending'] = $pending;
                    $results['reject'] = $reject;
                    $results['withdrawn'] = $withdrawn;

                    return response()->json($results, 200);
                break;

                case 'dashboard-admin-2':
                    DB::enableQueryLog();

                    $filters = request()->periode ?? Carbon::now('Asia/Jakarta')->format('Y');

                    $months = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember'
                    ];

                    $totals = DB::table('tpo_header as a')
                        ->select(DB::raw('sum(b.sellprice * b.qty) as po_amount'))
                        ->join('tpo_detail as b', function($join) {
                            $join->on('a.client_id', '=', 'b.client_id')
                                ->on('a.po_number', '=', 'b.po_number')
                                ->on('a.po_date', '=', 'b.po_date');
                        })
                        ->whereIn('a.status', ['2', '3', '4'])
                        ->where('a.po_date', 'like', $filters . '%')
                        ->first();

                    $gross = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $sqlGross = DB::table('tpo_header as a')
                            ->select(DB::raw('sum(b.sellprice * b.qty) as po_amount'))
                            ->join('tpo_detail as b', function($join) {
                                $join->on('a.client_id', '=', 'b.client_id')
                                    ->on('a.po_number', '=', 'b.po_number')
                                    ->on('a.po_date', '=', 'b.po_date');
                            })
                            ->whereIn('a.status', ['2', '3', '4'])
                            ->where('a.po_date', 'like', $filters . '-' . $month . '%')
                            ->first();

                        $gross[] = (int)$sqlGross->po_amount ?? 0;
                    }

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results['totals'] = number_format($totals->po_amount, 0, ",", ".") ?? 0;
                    $results['gross'] = $gross;

                    return response()->json($results, 200);
                break;

                case 'dashboard-supplier':
                    DB::enableQueryLog();

                    $publish = DB::table('tbook as a')->where('a.supplier_id', auth()->user()->client_id)->count();
                    $review = DB::table('tbook_draft as a')->where('a.supplier_id', auth()->user()->client_id)->where('a.status', '2')->count();

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
                            'c.status as status',
                            'c.payment_image as payment_image'
                        )
                        ->joinSub($tbook, 'b', function($join) {
                            $join->on('a.book_id', '=', 'b.book_id');
                        })
                        ->leftJoin('tpo_paid_off as c', function($join) {
                            $join->on('a.client_id', '=', 'c.client_id')
                                ->on('b.supplier_id', '=', 'c.supplier_id')
                                ->on('a.po_number', '=', 'c.po_number')
                                ->on('a.po_date', '=', 'c.po_date');
                        });

                    $purchase = DB::table('tpo_header as a')->sharedLock()
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
                            DB::raw("case when c.status != '' then c.status else a.status end as status"),
                            'c.payment_image as payment_image'
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
                            'a.status',
                            DB::raw("case when c.status != '' then c.status else a.status end"),
                            'c.payment_image'
                        )
                        ->get();

                    $paid = $purchase->filter(function ($item) {
                        return $item->status == 4;
                    });

                    $notPaid = $purchase->filter(function ($item) {
                        return $item->status == 3;
                    });

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results['publish'] = $publish;
                    $results['review'] = $review;
                    $results['paid'] = count($paid) ?? 0;
                    $results['notPaid'] = count($notPaid) ?? 0;

                    return response()->json($results, 200);
                break;

                case 'dashboard-supplier-1':
                    DB::enableQueryLog();

                    $filters = request()->periode ?? Carbon::now('Asia/Jakarta')->format('Y');

                    $months = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember'
                    ];

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
                            'c.status as status',
                            'c.payment_image as payment_image'
                        )
                        ->joinSub($tbook, 'b', function($join) {
                            $join->on('a.book_id', '=', 'b.book_id');
                        })
                        ->leftJoin('tpo_paid_off as c', function($join) {
                            $join->on('a.client_id', '=', 'c.client_id')
                                ->on('b.supplier_id', '=', 'c.supplier_id')
                                ->on('a.po_number', '=', 'c.po_number')
                                ->on('a.po_date', '=', 'c.po_date');
                        });

                    $totals = 0;
                    $total = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);

                        $purchase = DB::table('tpo_header as a')->sharedLock()
                            ->select(
                                'a.client_id as client_id',
                                'b.instansi_name as client_name',
                                'c.supplier_id as supplier_id',
                                'a.po_number as po_number',
                                'a.po_date as po_date',
                                'c.book_id as book_id',
                                DB::raw("case when c.status != '' then c.status else a.status end as status"),
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
                            ->where('a.po_date', 'like', $filters . '-' . $month . '%')
                            ->get();

                        $collectBook = $purchase->filter(function ($item) {
                            return $item->status == 3 || $item->status == 4;
                        })->count();

                        $totals += $collectBook ?? 0;
                        $total[$months[$i]] = $collectBook ?? 0;
                    }

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results['totals'] = $totals;
                    $results['total'] = $total;

                    return response()->json($results, 200);
                break;

                case 'dashboard-supplier-2':
                    DB::enableQueryLog();

                    $filters = request()->periode ?? Carbon::now('Asia/Jakarta')->format('Y');

                    $months = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember'
                    ];

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
                            'c.status as status',
                            'c.payment_image as payment_image'
                        )
                        ->joinSub($tbook, 'b', function($join) {
                            $join->on('a.book_id', '=', 'b.book_id');
                        })
                        ->leftJoin('tpo_paid_off as c', function($join) {
                            $join->on('a.client_id', '=', 'c.client_id')
                                ->on('b.supplier_id', '=', 'c.supplier_id')
                                ->on('a.po_number', '=', 'c.po_number')
                                ->on('a.po_date', '=', 'c.po_date');
                        });

                    $totals = 0;
                    $gross = [];
                    for ($i=1; $i <= 12; $i++) { 
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);

                        $purchase = DB::table('tpo_header as a')->sharedLock()
                            ->select(
                                'a.client_id as client_id',
                                'b.instansi_name as client_name',
                                'c.supplier_id as supplier_id',
                                'a.po_number as po_number',
                                'a.po_date as po_date',
                                DB::raw('sum(c.sellprice * c.qty) as po_amount'),
                                DB::raw("case when c.status != '' then c.status else a.status end as status"),
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
                            ->where('a.po_date', 'like', $filters . '-' . $month . '%')
                            ->groupBy(
                                'a.client_id',
                                'b.instansi_name',
                                'c.supplier_id',
                                'a.po_number',
                                'a.po_date',
                                DB::raw("case when c.status != '' then c.status else a.status end")
                            )
                            ->get();

                        $collectBook = $purchase->filter(function ($item) {
                            return $item->status == 3 || $item->status == 4;
                        });

                        $totals += $collectBook->sum('po_amount') ?? 0;
                        $gross[] = $collectBook->sum('po_amount') ?? 0;
                    }

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results['totals'] = number_format($totals, 0, ",", ".") ?? 0;
                    $results['gross'] = $gross;

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
     * @param ProfileCompanyRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(ProfileCompanyRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            $updated = DB::table('tcompany')
                ->updateOrInsert([
                    'id' => auth()->user()->client_id
                ], [
                    'name' => $request->name ?? '',
                    'email' => $request->email ?? '',
                    'country' => $request->country ?? '',
                    'province' => $request->province ?? '',
                    'regency' => $request->regency ?? '',
                    'district' => $request->district ?? '',
                    'subdistrict' => $request->subdistrict ?? '',
                    'postal_code' => $request->postal_code ?? '',
                    'address' => $request->address ?? '',
                    'telephone' => $request->telephone ?? '',
                    'handphone' => $request->handphone ?? '',
                    'director' => $request->director ?? '',
                    'position' => $request->position ?? '',
                    'handphone_director' => $request->handphone_director ?? '',
                    'pic' => $request->person_in_charge ?? '',
                    'handphone_pic' => $request->handphone_person_in_charge ?? '',
                    'file' => '',
                    'type' => $request->type == 'Supplier' ? '1' : ($request->type == 'Distributor' ? '2' : '3'),
                    'updated_at' => Carbon::now('Asia/Jakarta'),
                    'updated_by' => $request->email ?? '',
                ]);
            
            if ($updated) {
                if ($request->password) {
                    $user = Auth::user();
                    $user->password = bcrypt($request->password);
                    $user->updated_at = Carbon::now('Asia/Jakarta');
                    $user->save();
                }
                
                $bank = DB::table('tcompany_bank_account')
                ->updateOrInsert([
                    'client_id' => auth()->user()->client_id,
                ], [
                    'npwp' => $request->npwp,
                    'account_bank' => $request->account_bank,
                    'bank' => $request->bank,
                    'account_name' => $request->account_name,
                    'bank_city' => $request->bank_city,
                    'updated_at' => Carbon::now('Asia/Jakarta'),
                    'updated_by' => $request->email,
                ]);
    
                $imprint = request()->imprint;
                if (count($imprint) > 0) {
                    $delete_imp = DB::table('tpublisher')->where('client_id', auth()->user()->client_id)->where('flag', 'I')->delete();
                    foreach ($imprint as $key => $value) {
                        $updated = DB::table('tpublisher')
                            ->insert([
                                'client_id' => auth()->user()->client_id,
                                'id' => $value['id'] != '' ? $value['id'] : Str::uuid(),
                                'description' => $value['name'],
                                'flag' => 'I',
                                'created_at' => Carbon::now('Asia/Jakarta'),
                                'updated_at' => Carbon::now('Asia/Jakarta'),
                            ]);
                    }
                }
    
                $publisher = request()->publisher;
                if (count($publisher) > 0) {
                    $delete_pub = DB::table('tpublisher')->where('client_id', auth()->user()->client_id)->where('flag', 'K')->delete();
                    foreach ($publisher as $key => $value) {
                        $updated = DB::table('tpublisher')
                            ->insert([
                                'client_id' => auth()->user()->client_id,
                                'id' => $value['id'] != '' ? $value['id'] : Str::uuid(),
                                'description' => $value['name'],
                                'flag' => 'K',
                                'created_at' => Carbon::now('Asia/Jakarta'),
                                'updated_at' => Carbon::now('Asia/Jakarta'),
                            ]);
                    }
                }
    
                $category = request()->category;
                if (count($category) > 0) {
                    $delete_cat = DB::table('tcompany_category')->where('client_id', auth()->user()->client_id)->delete();
                    foreach ($category as $key => $value) {
                        $updated = DB::table('tcompany_category')
                            ->insert([
                                'client_id' => auth()->user()->client_id,
                                'category_id' => $value['id'],
                                'category_desc' => $value['desc'],
                                'created_at' => Carbon::now('Asia/Jakarta'),
                                'created_by' => auth()->user()->email,
                                'updated_at' => Carbon::now('Asia/Jakarta'),
                                'updated_by' => auth()->user()->email,
                            ]);
                    }
                }

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
        return response()->json(['id' => $id], 200);
    }

    public function agreementLetter(Request $request)
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $filter['id'] = explode('_', $request->id)[0];

        $results = [];
        try {
            DB::enableQueryLog();

            $results['profile'] = DB::table('tcompany as a')->sharedLock()
                ->select(
                    'a.id as id',
                    'a.name as name',
                    'a.email as email',
                    'a.country as country',
                    'a.province as province',
                    'b.provinsi_name as province_name',
                    'a.regency as regency',
                    'c.kabupaten_name as regency_name',
                    'a.district as district',
                    'd.kecamatan_name as district_name',
                    'a.subdistrict as subdistrict',
                    'e.kelurahan_name as subdistrict_name',
                    'a.postal_code as postal_code',
                    'a.address as address',
                    'a.telephone as telephone',
                    'a.handphone as handphone',
                    'a.director as director',
                    'a.position as position',
                    'a.handphone_director as handphone_director',
                    'a.pic as pic',
                    'a.handphone_pic as handphone_pic',
                    'a.file as file',
                    'a.agreement as agreement',
                    'a.type as type',
                    'a.documents as documents',
                    'a.created_at as created_at',
                    'a.created_by as created_by',
                    'a.updated_at as updated_at',
                    'a.updated_by as updated_by',
                )
                ->join('tprovinsi as b', function($join) {
                    $join->on('a.province', '=', 'b.provinsi_id');
                })
                ->join('tkabupaten as c', function($join) {
                    $join->on('a.province', '=', 'c.provinsi_id')
                        ->on('a.regency', '=', 'c.kabupaten_id');
                })
                ->join('tkecamatan as d', function($join) {
                    $join->on('a.province', '=', 'd.provinsi_id')
                        ->on('a.regency', '=', 'd.kabupaten_id')
                        ->on('a.district', '=', 'd.kecamatan_id');
                })
                ->join('tkelurahan as e', function($join) {
                    $join->on('a.province', '=', 'e.provinsi_id')
                        ->on('a.regency', '=', 'e.kabupaten_id')
                        ->on('a.district', '=', 'e.kecamatan_id')
                        ->on('a.subdistrict', '=', 'e.kelurahan_id');
                })
                ->when($filter['id'] != '', function ($query) use ($filter) {
                    $query->where('a.id', $filter['id']);
                }, function($query) use ($filter) {
                    $query->where('a.id', auth()->user()->client_id);
                })
                ->get();

            $results['imprint'] = DB::table('tpublisher as a')->sharedLock()
                ->select(
                    'a.id as id',
                    'a.description as name'
                )
                ->when($filter['id'] != '', function ($query) use ($filter) {
                    $query->where('a.client_id', $filter['id']);
                }, function($query) use ($filter) {
                    $query->where('a.client_id', auth()->user()->client_id);
                })
                ->where('a.flag', 'I')
                ->get();

            $results['kuasa'] = DB::table('tpublisher as a')->sharedLock()
                ->select(
                    'a.id as id',
                    'a.description as name'
                )
                ->when($filter['id'] != '', function ($query) use ($filter) {
                    $query->where('a.client_id', $filter['id']);
                }, function($query) use ($filter) {
                    $query->where('a.client_id', auth()->user()->client_id);
                })
                ->where('a.flag', 'K')
                ->get();

            $results['category'] = DB::table('tcompany_category as a')->sharedLock()
                ->select(
                    'a.category_id as id',
                    'a.category_desc as name'
                )
                ->when($filter['id'] != '', function ($query) use ($filter) {
                    $query->where('a.client_id', $filter['id']);
                }, function($query) use ($filter) {
                    $query->where('a.client_id', auth()->user()->client_id);
                })
                ->get();

            $results['account'] = DB::table('tcompany_bank_account as a')->sharedLock()
                ->select(
                    'a.npwp as npwp',
                    'a.account_bank as account_bank',
                    'a.bank as bank',
                    'a.account_name as account_name',
                    'a.bank_city as bank_city'
                )
                ->when($filter['id'] != '', function ($query) use ($filter) {
                    $query->where('a.client_id', $filter['id']);
                }, function($query) use ($filter) {
                    $query->where('a.client_id', auth()->user()->client_id);
                })
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

        return view('pdf.agreement_letter', ['results' => json_decode(json_encode($results), FALSE)]);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadFile(Request $request)
    {
        $filePath = public_path('guide/manual-guide.pdf');

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $fileContent = file_get_contents($filePath);

        return response()->make($fileContent, 200, [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Type'          => mime_content_type($filePath),
            'Content-Length'        => filesize($filePath),
            'Content-Disposition'   => 'attachment; filename="' . basename($filePath) . '"',
            'Pragma'                => 'public',
        ]);
    }
}
