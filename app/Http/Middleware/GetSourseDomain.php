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
            $request->merge([
                'ATSAST_DOMAIN' => $domain
            ]);
        }else{
            $request->merge([
                'ATSAST_DOMAIN' => ''
            ]);
        }
        return $next($request);
    }
}
