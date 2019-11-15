<?php

namespace App\Http\Middleware\Contest;

use App\Models\ResponseModel;
use Closure;
use Auth;

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
                return ResponseModel::err(2003);
            }
        }
        return $next($request);
    }
}
