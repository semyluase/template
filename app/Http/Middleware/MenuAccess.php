<?php

namespace App\Http\Middleware;

use App\Models\UserMenu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuAccess
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
        // $menuExists = UserMenu::where('username', $request->user()->username)
        //         ->first();

        // if (!$menuExists) {
        //     return response()->view('errors.404');
        // }
        return $next($request);

    }
}
