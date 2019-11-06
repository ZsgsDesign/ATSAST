<?php

namespace App\Http\Middleware\Contest;

use App\Models\Eloquents\Contest;
use Closure;

class Exist
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
        $cid = $request->cid;
        $contest = Contest::find($cid);
        if(empty($contest)){
            if($request->isMethod('get')){
                return redirect($request->ATSAST_DOMAIN.route('contest'));
            }else{
                return ResponseModel::err(2003);
            }
        }
        $request->merge([
            'contest' => $contest
        ]);
        return $next($request);
    }
}
