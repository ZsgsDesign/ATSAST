<?php

namespace App\Http\Middleware\Course;

use Closure;
use Illuminate\Support\Facades\Auth;

class Register
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
        $course = $request->course;
        $register = $course->registers()->where('uid',$user->id);
        if(empty($register)){
            if($request->isMethod('get')){
                return redirect()->route('course.detail',['cid' => $course->course_id]);
            }else{
                return ResponseModel::err(3001);
            }
        };
        return $next($request);
    }
}
