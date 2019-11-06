<?php

namespace App\Http\Middleware\Course;

use Closure;

class SyllabusExist
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
        $syid = $request->syid;
        $course = $request->course;
        $syllabus = $course->syllabus()->where('syid',$syid)->first();
        if(empty($syllabus)){
            if($request->isMethod('get')){
                return redirect(($request->ATSAST_DOMAIN).route('course.manage',['cid' => $course->cid],false));
            }else{
                return ResponseModel::err(3003);
            }
        }
        $request->merge([
            'syllabus' => $syllabus
        ]);
        return $next($request);
    }
}
