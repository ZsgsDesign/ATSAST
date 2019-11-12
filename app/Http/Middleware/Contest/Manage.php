<?php

namespace App\Http\Middleware\Contest;

use Closure;

class Manage
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
        $contest = $request->contest;
        if(!$contest->is_manager(Auth::user()->id) && !Auth::user()->hasAccess('system.contest.manage')){
            if($request->isMethod('get')){
                return redirect(request()->ATSAST_DOMAIN.route('contest.index',null,false));
            }else{
                return ResponseModel::err(4011);
            }
        }
        return $next($request);
    }
}
