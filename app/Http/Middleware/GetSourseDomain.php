<?php

namespace App\Http\Middleware;

use Closure;

class GetSourseDomain
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
        $domain = $request->header('ATSAST-DOMAIN', null);
        $allow_domain = [
            'https://sast.njupt.edu.cn/atsast',
            'https://mundb.xyz',
            'http://47.101.177.238'
        ];
        if(in_array($domain,$allow_domain)){
            view()->share('ATSAST_DOMAIN',$domain);
        }else{
            view()->share('ATSAST_DOMAIN','');
        }
        return $next($request);
    }
}
