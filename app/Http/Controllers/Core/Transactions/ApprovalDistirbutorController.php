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

class ApprovalDistirbutorController extends Controller
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
                    'a.name as supplierName',
                    'a.email as email',
                    'b.country_name as country',
                    'c.provinsi_name as province',
                    'd.kabupaten_name as regency',
                    'e.kecamatan_name as district',
                    'f.kelurahan_name as subDistrict',
                    'a.address as address',
                    'a.handphone as supplierPhone',
                    'a.director as directorName',
                    'a.handphone_director as directorPhone',
                    'a.pic as personInChargeName',
                    'a.handphone_pic as personInChargePhone',
                    'g.email_verified_at as emailVerifiedAt',
                    'a.type as type',
                    'g.status as status',
                )
                ->join('users as g', function($join) {
                    $join->on('a.id', '=', 'g.client_id');
                })
                ->join('tcountry as b', function($join) {
					$join->on('a.country', '=', 'b.country_id');
				})
                ->join('tprovinsi as c', function($join) {
                    $join->on('a.province', '=', 'c.provinsi_id');
                })
                ->join('tkabupaten as d', function($join) {
                    $join->on('a.regency', '=', 'd.kabupaten_id');
                })
                ->join('tkecamatan as e', function($join) {
                    $join->on('a.district', '=', 'e.kecamatan_id');
                })
                ->join('tkelurahan as f', function($join) {
                    $join->on('a.subdistrict', '=', 'f.kelurahan_id');
                })
                ->where('a.type', '2')
                ->where('g.status', 0)
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
            ->addIndexColumn()
            ->editColumn('type', function ($value) {
                return $value->type == '1' ? 'Supplier' : 'Distributor';
            })
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
                $approve = DB::table('users')
                    ->where('client_id', $value)
                    ->update([
                        'status' => 1,
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
                $reject = DB::table('users')
                    ->where('client_id', $value)
                    ->update([
                        'status' => 2,
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
