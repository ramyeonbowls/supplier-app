<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\WebAccessLogService;

class WebAccessLogController extends Controller
{
    protected $webAccessLogService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(WebAccessLogService $webAccessLogService)
    {
        $this->middleware('auth');
        $this->webAccessLogService = $webAccessLogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('name')) {
            $results['status'] = 200;
            $results['success'] = false;
            $results['message'] = '';
            try {
                $webAccessLog = $this->webAccessLogService->createAccessLog($request);

                if($webAccessLog) {
                    $results['status'] = 201;
                    $results['success'] = true;
                    $results['message'] = 'Successfully record access logs.';
                }
            } catch (\Throwable $th) {
                $results['status'] = 500;
                $results['message'] = $th->getMessage();
            }

            return response()->json($results, $results['status']);
        }
        return response()->json('no record access logs.', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results['status'] = 200;
        $results['success'] = true;
        $results['message'] = '';
        try {
            $webAccessLog = $this->webAccessLogService->getAclPermission($id);

            if($webAccessLog) {
                return response()->json($webAccessLog, 200);
            } else {
                $results['status'] = 403;
                $results['success'] = false;
                $results['message'] = 'We are sorry but you do not have permission to access this page';
            }
        } catch (\Throwable $th) {
            $results['status'] = 500;
            $results['success'] = false;
            $results['message'] = $th->getMessage();
        }

        return response()->json($results, $results['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
