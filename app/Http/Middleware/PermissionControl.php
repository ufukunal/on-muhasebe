<?php

namespace App\Http\Middleware;

use App\UserPermission;
use Closure;
use Illuminate\Support\Facades\Config;

class PermissionControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix = str_replace('/' ,'', request()->route()->getPrefix());

        $index = array_search($prefix, Config::get('app.permissions'));

        if(!UserPermission::getMyControl($index)){ return redirect('/'); }

        return $next($request);
    }
}
