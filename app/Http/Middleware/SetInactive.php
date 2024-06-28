<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SetInactive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $lastActive = Carbon::parse($user->lastActive ?? '0000-00-00 00:00:00');
        $checkTime = Carbon::now()->subMinutes(30)->toDateTimeString();

        if (Auth::check())
        {
            if ($lastActive < $checkTime)
            {
                $user->isActive = false;
            } else {
                $user->isActive = true;
            }

            $user->save();
        }

        return $next($request);
    }
}
