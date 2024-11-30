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

class ApprovalClientController extends Controller
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

            $results = DB::table('tclient as a')->sharedLock()
                ->select(
                    'a.client_id as client_id',
                    'a.instansi_name as instansi_name',
                    'a.application_name as application_name',
                    'a.address as address',
                    'a.negara_id as negara_id',
                    'b.country_name as negara_name',
                    'a.provinsi_id as provinsi_id',
                    'c.provinsi_name as provinsi_name',
                    'a.kabupaten_id as kabupaten_id',
                    'd.kabupaten_name as kabupaten_name',
                    'a.kecamatan_id as kecamatan_id',
                    'e.kecamatan_name as kecamatan_name',
                    'a.kelurahan_id as kelurahan_id',
                    'f.kelurahan_name as kelurahan_name',
                    'a.kodepos as kodepos',
                    'a.npwp as npwp',
                    'a.pers_responsible as pers_responsible',
                    'a.pos_pers_responsible as pos_pers_responsible',
                    'a.mou_sign_name as mou_sign_name',
                    'a.pos_sign_name as pos_sign_name',
                    'a.administrator_name as administrator_name',
                    'a.administrator_phone as administrator_phone',
                    'a.logo as logo',
                    'a.logo_small as logo_small',
                    'a.company_id as company_id',
                    'e.name as company_name',
                    'a.web_add as web_add',
                    'a.agreement as agreement',
                    'a.client_category as client_category',
                    'a.client_level as client_level',
                    'a.flag_appr as flag_appr',
                    'a.created_at as created_at',
                    'a.updated_at as updated_at',
                )
                ->join('tcountry as b', function($join) {
					$join->on('a.negara_id', '=', 'b.country_id');
				})
                ->join('tprovinsi as c', function($join) {
					$join->on('a.provinsi_id', '=', 'c.provinsi_id');
				})
                ->join('tkabupaten as d', function($join) {
					$join->on('a.kabupaten_id', '=', 'd.kabupaten_id');
				})
                ->join('tkecamatan as e', function($join) {
					$join->on('a.kecamatan_id', '=', 'e.kecamatan_id');
				})
                ->join('tkelurahan as f', function($join) {
					$join->on('a.kelurahan_id', '=', 'f.kelurahan_id');
				})
                ->leftJoin('tcompany as e', function($join) {
					$join->on('a.company_id', '=', 'e.id')
                        ->on('e.type', '=', '2');
				})
                ->orderBy('a.flag_appr', 'asc')
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
            ->editColumn('logo', function ($value) {
                $path = 'storage/images/logo/';
                return file_exists(public_path($path . $value->logo)) ? $path . $value->logo : '';
            })
            ->editColumn('logo_small', function ($value) {
                $path = 'storage/images/logo/';
                return file_exists(public_path($path . $value->logo_small)) ? $path . $value->logo_small : '';
            })
            ->editColumn('web_add', function ($value) {
                return $value->web_add . '.pustakadigital.id';
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
                $approve = DB::table('tclient')
                    ->where('client_id', $value)
                    ->update([
                        'flag_appr' => 'Y',
                        'updated_at' => Carbon::now('Asia/Jakarta')
                    ]);
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

            $result['status'] = 500;
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
        return response()->json(['id' => $id], 200);
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
     * reject a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function reject(Request $request): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            foreach (request()->request->all() as $key => $value) {
                $reject = DB::table('tclient')
                ->where('client_id', $value)
                ->update([
                    'flag_appr' => 'R',
                    'updated_at' => Carbon::now('Asia/Jakarta')
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

            $result['status'] = 500;
            $result['message'] = "Failed Reject.<br>" . $th->getMessage();
        }

        return response()->json($result['message'], $result['status']);
    }
}
