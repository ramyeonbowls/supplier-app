<?php

namespace App\Http\Controllers\Core\Upload;

use Exception;
use Throwable;
use App\Logs;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadBooksController extends Controller
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
        return response()->json($request, 200);
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

            if ($request->hasFile('file_cover')) {
                try {
                    $file_cover = $request->file('file_cover')->getClientOriginalName();

                    $zipObj = new \ZipArchive();
                    $file = $zipObj->open($request->file('file_cover')->path());
                    if ($file === TRUE) {
                        $logs->write('ZIP', 'OPEN SUCCESS');

                        if($zipObj->extractTo(storage_path('app/private/books/'.explode('.', str_replace(' ', '', $file_cover))[0]))) {
                            $zipObj->close();

                            $logs->write('ZIP', 'EXTRAC SUCCESS');
                        } else {
                            $logs->write('ZIP', 'EXTRAC FAILED');
                        }
                    } else {
                        $logs->write('ZIP', 'OPEN FAILED');
                    }
                    // $banner_file = $request->file('file')->getClientOriginalName();
                    // $extension = $request->file('file')->getClientOriginalExtension();
                    // $banner_name = explode('.', str_replace(' ', '', $banner_file))[0] . '-' . now('Asia/Jakarta')->format('YmdHis') . '-' . rand(100000, 999999) . '.' . $extension;
                    // $request->file('file')->storeAs('/public/images/banner', $banner_name);

                    // $validated['file'] = '/storage/images/banner/'.$banner_name;
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

           /*  $updated = $this->banner_service->update((object)$validated, $id);
            if ($updated) {
                $logs->write("INFO", "Successfully updated");

                $result['status'] = 201;
                $result['message'] = "Successfully updated.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            } */
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

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
        return response()->json($id, 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json($id, 200);
    }
}
