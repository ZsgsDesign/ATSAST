<?php

namespace App\Http\Middleware\Contest;

use App\Models\ResponseModel;
use Closure;
use Auth;

class RegisterIsDue
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
        $due_time = strtotime($contest->due_register);
        if(time()>$due_time && !$contest->userRegister(Auth::user()->id)) {
            if($request->isMethod('get')){
                return redirect(request()->ATSAST_DOMAIN.route('contest.detail',['cid' => $contest->contest_id],false));
            }else{
                return ResponseModel::err(4012);
            }
        }
        return $next($request);
    }
}
