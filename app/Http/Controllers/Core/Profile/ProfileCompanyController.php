<?php

namespace App\Http\Controllers\Core\Profile;

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

            $results = DB::table('tclient as a')->sharedLock()
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

                    $ketegori = DB::table('tclient_category as a')->sharedLock()
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

                    $ketegori = DB::table('tclient_bank_account as a')->sharedLock()
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
                $delete_cat = DB::table('tclient_category')->where('client_id', auth()->user()->client_id)->delete();
                foreach ($category as $key => $value) {
                    $updated = DB::table('tclient_category')
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
            
            if ($updated) {
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

        $results = [];
        try {
            DB::enableQueryLog();

            $results['profile'] = DB::table('tclient as a')->sharedLock()
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

            $results['imprint'] = DB::table('tpublisher as a')->sharedLock()
                ->select(
                    'a.id as id',
                    'a.description as name'
                )
                ->where('a.client_id', auth()->user()->client_id)
                ->where('a.flag', 'I')
                ->get();

            $results['kuasa'] = DB::table('tpublisher as a')->sharedLock()
                ->select(
                    'a.id as id',
                    'a.description as name'
                )
                ->where('a.client_id', auth()->user()->client_id)
                ->where('a.flag', 'K')
                ->get();

            $results['category'] = DB::table('tclient_category as a')->sharedLock()
                ->select(
                    'a.category_id as id',
                    'a.category_desc as name'
                )
                ->where('client_id', auth()->user()->client_id)
                ->get();

            $results['account'] = DB::table('tclient_bank_account as a')->sharedLock()
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
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return view('pdf.agreement_letter', ['results' => json_decode(json_encode($results), FALSE)]);
    }
}
