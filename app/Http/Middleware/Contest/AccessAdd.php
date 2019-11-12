<?php

namespace App\Http\Middleware\Contest;

use Closure;
use Auth;

class AccessAdd
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
        $user = Auth::user();
        if(!$user->hasAccess('contest.add')){
            if($request->isMethod('get')){
                return redirect($request->ATSAST_DOMAIN.route('contest.index',null,false));
            }else{
                return ResponseModel::err(2003);
            }
        }
        return $next($request);
    }
}
