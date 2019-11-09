<?php

namespace App\Http\Middleware\Course\Add;

use App\Models\ResponseModel;
use App\User;
use Closure;

class InstructorsEmailExist
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
        if(!$request->has('email') || $request->email == ''){
            return ResponseModel::err(1003);
        }
        $emails = explode(';',$request->email);
        $instructors = [];
        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            if(empty($user)) {
                return ResponseModel::err(2002,null,null,[
                    '该用户' => "用户{$email},请检查输入是否正确以及该同学是否已注册"
                ]);
            }
            $instructors[] = $user;
        }
        $request->merge([
            'instructors' => $instructors
        ]);
        return $next($request);
    }
}
