<?php

namespace App\Http\Middleware\Course\Add;

use Closure;
use Auth;
use App\Models\ResponseModel;

class Access
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
        if(!$user->hasAccess('course.add')){
            if($request->isMethod('get')){
                return redirect($request->ATSAST_DOMAIN.route('course',null,false));
            }else{
                return ResponseModel::err(2003);
            }
        }
        return $next($request);
    }
}
