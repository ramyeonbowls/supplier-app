<?php

namespace App\Http\Middleware;

use Browser;
use Closure;
use App\Logs;
use App\Models\Web\UserOnline;
use App\Models\Web\BrowserSessionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivatedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        try {
            BrowserSessionLog::updateOrCreate([
                'username' => $user->name,
                'visitor' => request()->getClientIp(),
                'platform' => Browser::platformFamily(),
                'device' => Browser::isDesktop() ? 'Desktop' : Browser::deviceFamily(),
                'browser' => Browser::browserFamily()
            ],[
                'browser_name' => Browser::browserName(),
                'user_agent' => Browser::userAgent(),
                'updated_at' => Carbon::now()
            ]);
        } catch (\Throwable $th) {
            $logs = new Logs('BrowserSession');
            $logs->write("USERID", $user->name);
            $logs->write("ERROR", $th->getMessage() ."\r\n");
        }

        try {
            UserOnline::updateOrCreate([
                'username' => $user->name
            ],[
                'online' => true,
                'status' => 'Online',
                'updated_at' => Carbon::now()
            ]);
        } catch (\Throwable $th) {
            $logs = new Logs('UserOnline');
            $logs->write("USERID", $user->name);
            $logs->write("ERROR", $th->getMessage() ."\r\n");
        }

        return $next($request);
    }
}
