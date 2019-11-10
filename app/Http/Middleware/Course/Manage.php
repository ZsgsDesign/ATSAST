<?php

namespace App\Http\Middleware\Course;

use App\Models\Eloquents\Course;
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
        $course = $request->course;
        if(!$course->is_manager(Auth::user()->id) && !Auth::user()->hasAccess('system.course.manage')){
            if($request->isMethod('get')){
                return redirect(request()->ATSAST_DOMAIN.route('course',null,false));
            }else{
                return ResponseModel::err(2003);
            }
        }
        return $next($request);
    }
}
