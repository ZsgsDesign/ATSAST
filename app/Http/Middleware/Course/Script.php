<?php

namespace App\Http\Middleware\Course;

use Closure;

class Script
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
        $syllabus = $request->syllabus;
        if(!$syllabus->script){
            $course = $request->course;
            return redirect(request()->ATSAST_DOMAIN.route('course.detail',['cid'=>$course->course_id],false));
        }
        return $next($request);
    }
}
