<?php

namespace App\Http\Controllers\Core\Report;

use Exception;
use File;
use Throwable;
use App\Logs;
use App\Exports\Report\ReportSupplier\ReportSupplierExport;
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

class ReportSupplierController extends Controller
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
                    'a.id as Id',
                    'a.name as SupplierName',
                    'a.email as Email',
                    'b.country_name as Country',
                    'c.provinsi_name as Province',
                    'd.kabupaten_name as Regency',
                    'e.kecamatan_name as District',
                    'f.kelurahan_name as SubDistrict',
                    'a.address as Address',
                    'a.handphone as SupplierPhone',
                    'a.director as DirectorName',
                    'a.handphone_director as DirectorPhone',
                    'a.pic as PersonInChargeName',
                    'a.handphone_pic as PersonInChargePhone'
                )
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
                ->join('users as g', function($join) {
                    $join->on('a.id', '=', 'g.client_id');
                })
                ->where('a.type', '1')
                ->where('g.status', 1)
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
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportTpl(Request $request): BinaryFileResponse
    {
        return Excel::download(new ReportSupplierExport([]), 'report_supplier.xlsx');
    }
}
