<?php

namespace App\Http\Middleware\Course;

use Closure;
use Illuminate\Support\Facades\Auth;

class Feedback
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
        if(!$syllabus->feedback){
            $course = $request->course;
            return redirect()->route('course.detail',['cid'=>$course->course_id]);
        }
        $user = Auth::user();
        $feedback = $syllabus->feedbacks()->where('uid',$user->id)->first();
        $request->merge([
            'feedback' => $feedback
        ]);
        return $next($request);
    }
}
