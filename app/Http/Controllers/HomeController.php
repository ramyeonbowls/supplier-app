<?php

namespace App\Http\Controllers;

use App\Logs;
use App\Services\Web\WebMenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userInfo()
    {
        $user = auth()->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ], 200);
    }

    /**
     * Show the application menus.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function webMenuAcl()
    {
        $logs = new Logs( auth()->user()->email .'_'. Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");

        $my_webmenus = [];
        try {
            $webMenuService = new WebMenuService(new \App\Repositories\Web\WebMenuRepository());
            $my_webmenus = $webMenuService->getAccessControlList(auth()->user()->email);
        } catch (\Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($my_webmenus, 200);
    }
}
