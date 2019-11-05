<?php

namespace App\Http\Middleware\Course;

use App\Models\Eloquents\Course;
use App\Models\ResponseModel;
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
        $course = Course::with('organization')->find($cid);
        if(empty($course)){
            if($request->isMethod('get')){
                return redirect()->route('course');
            }else{
                return ResponseModel::err(3002);
            }
        }
        $request->merge([
            'course' => $course
        ]);
        return $next($request);
    }
}
