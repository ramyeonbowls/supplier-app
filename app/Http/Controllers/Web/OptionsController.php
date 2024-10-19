<?php

namespace App\Http\Controllers\Web;

use App\Logs;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class OptionsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(['request' => $request], 200);
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
     * @param  string  $id
     * @return JsonResponse
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
     * Get the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function signature(Request $request)
    {
        $client_id = $request->id ?? '';

        if ($client_id != '') {
            $id = DB::table('tclient as a')->sharedLock()
                ->select(
                    'a.name as name',
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
                    'a.director as director',
                    'a.position as position',
                    'a.created_at as created_at',
                    'a.created_by as created_by',
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
                ->where('a.id', $client_id)
                ->first();

                $id = json_decode(json_encode($id));
        } else {
            $id = [
                'name' => 'PT. GINESIA DIGITAL INDONESIA',
                'country' => '',
                'province' => '',
                'province_name' => '',
                'regency' => '',
                'regency_name' => 'Yogyakarta',
                'district' => '',
                'district_name' => '',
                'subdistrict' => '',
                'subdistrict_name' => '',
                'postal_code' => '',
                'director' => 'Irfan Hilmi',
                'position' => 'Direktur',
                'created_at' => '',
                'created_by' => '',
            ];

            $id = json_decode(json_encode($id));
        }

        return view('signature', compact('id'));
    }
}
