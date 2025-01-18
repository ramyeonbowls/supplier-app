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

class ApprovalEditClientController extends Controller
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

            $results = DB::table('tclient_temp as a')->sharedLock()
                ->select(
                    'a.client_id as client_id',
                    'a.instansi_name as instansi_name',
                    'a.application_name as application_name',
                    'a.address as address',
                    'a.country_id as negara_id',
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
                    'g.name as company_name',
                    'a.web_add as web_add',
                    'a.agreement as agreement',
                    'a.client_category as client_category',
                    'a.client_level as client_level',
                    'a.flag_appr as flag_appr',
                    'a.created_at as created_at',
                    'a.updated_at as updated_at',
                )
                ->join('tcountry as b', function($join) {
					$join->on('a.country_id', '=', 'b.country_id');
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
                ->leftJoin('tcompany as g', function($join) {
					$join->on('a.company_id', '=', 'g.id')
                        ->on('g.type', '=', DB::raw("'2'"));
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

            $approve = DB::table('tclient_temp')
                ->where('client_id', $request->client_id)
                ->update([
                    'flag_appr' => 'Y',
                    'updated_at' => Carbon::now('Asia/Jakarta')
                ]);
            
            if ($approve) {
                $update = DB::table('tclient')
                    ->updateOrInsert([
                        'client_id' => $request->client_id,
                    ], [
                        'instansi_name' => $request->instansi_name,
                        'application_name' => $request->application_name,
                        'address' => $request->address,
                        'country_id' => $request->negara_id,
                        'provinsi_id' => $request->provinsi_id,
                        'kabupaten_id' => $request->kabupaten_id,
                        'kecamatan_id' => $request->kecamatan_id,
                        'kelurahan_id' => $request->kelurahan_id,
                        'kodepos' => $request->kodepos,
                        'npwp' => $request->npwp,
                        'pers_responsible' => $request->pers_responsible,
                        'pos_pers_responsible' => $request->pos_pers_responsible,
                        'mou_sign_name' => $request->mou_sign_name,
                        'pos_sign_name' => $request->pos_sign_name,
                        'administrator_name' => $request->administrator_name,
                        'administrator_phone' => $request->administrator_phone,
                        'web_add' => $request->web_add,
                    ]);

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
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');

        if (request()->has('param') && request()->param != '') {
            switch (request()->param) {
                case 'client-mst':
                    DB::enableQueryLog();

                    $client_id = request()->client ?? '';
                    $client = DB::table('tclient as a')->sharedLock()
                        ->select(
                            'a.client_id as client_id',
                            'a.instansi_name as instansi_name',
                            'a.application_name as application_name',
                            'a.address as address',
                            'a.country_id as negara_id',
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
                            'g.name as company_name',
                            'a.web_add as web_add',
                            'a.agreement as agreement',
                            'a.client_category as client_category',
                            'a.client_level as client_level',
                            'a.flag_appr as flag_appr',
                            'a.created_at as created_at',
                            'a.updated_at as updated_at',
                        )
                        ->join('tcountry as b', function($join) {
                            $join->on('a.country_id', '=', 'b.country_id');
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
                        ->leftJoin('tcompany as g', function($join) {
                            $join->on('a.company_id', '=', 'g.id')
                                ->on('g.type', '=', DB::raw("'2'"));
                        })
                        ->where('a.client_id', $client_id)
                        ->orderBy('a.flag_appr', 'asc')
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($client) {
                        $results = $client->map(function($value, $key) {
                            return [
                                'client_id' => $value->client_id,
                                'instansi_name' => $value->instansi_name,
                                'application_name' => $value->application_name,
                                'address' => $value->address,
                                'negara_id' => $value->negara_id,
                                'negara_name' => $value->negara_name,
                                'provinsi_id' => $value->provinsi_id,
                                'provinsi_name' => $value->provinsi_name,
                                'kabupaten_id' => $value->kabupaten_id,
                                'kabupaten_name' => $value->kabupaten_name,
                                'kecamatan_id' => $value->kecamatan_id,
                                'kecamatan_name' => $value->kecamatan_name,
                                'kelurahan_id' => $value->kelurahan_id,
                                'kelurahan_name' => $value->kelurahan_name,
                                'kodepos' => $value->kodepos,
                                'npwp' => $value->npwp,
                                'pers_responsible' => $value->pers_responsible,
                                'pos_pers_responsible' => $value->pos_pers_responsible,
                                'mou_sign_name' => $value->mou_sign_name,
                                'pos_sign_name' => $value->pos_sign_name,
                                'administrator_name' => $value->administrator_name,
                                'administrator_phone' => $value->administrator_phone,
                                'logo' => $value->logo,
                                'logo_small' => $value->logo_small,
                                'company_id' => $value->company_id,
                                'company_name' => $value->company_name,
                                'web_add' => $value->web_add,
                                'agreement' => $value->agreement,
                                'client_category' => $value->client_category,
                                'client_level' => $value->client_level,
                                'flag_appr' => $value->flag_appr,
                                'created_at' => $value->created_at,
                                'updated_at' => $value->updated_at,
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

            $reject = DB::table('tclient_temp')
                ->where('client_id', $request->client_id)
                ->update([
                    'flag_appr' => 'R',
                    'updated_at' => Carbon::now('Asia/Jakarta')
                ]);
            
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
