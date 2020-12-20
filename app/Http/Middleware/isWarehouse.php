<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isWarehouse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->get('id_role') <= 0){
            return redirect('/');
        }
        return $next($request);
    }
}
