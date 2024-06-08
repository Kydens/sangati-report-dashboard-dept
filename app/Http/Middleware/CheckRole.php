<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Roles;
use App\Models\Departemen;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $reqDept, $reqRole = null): Response
    {
        $user = Auth::user();
        $departemen = Departemen::where('id', $reqDept)->first();

        if($user->departemen_id == $departemen->id) {
            if($reqRole) {
                $role = Roles::where('id', $reqRole)->first();
                if($user->roles_id == $role->id) {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
        }

        return redirect('/dashboard')->with('error-unauthorized', 'User Unauthorized! Not allow to access!');
    }
}
