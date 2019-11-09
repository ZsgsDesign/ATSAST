<?php

namespace App\Http\Middleware\Course\Add;

use App\Models\ResponseModel;
use Closure;

class ValidColorAndLogo
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
        if(!$request->has('logo') || $request->logo == '' || !$request->has('color') || $request->color == ''){
            return ResponseModel::err(1003,null,null,[
                '参数' => '参数logo或color'
            ]);
        }
        $logo = $request->logo;
        if(strlen($logo) > 3){
            $pattern_MDI = '/^MDI [A-Za-z\-]+$/';
            $pattern_dev = '/devicon-\w+-plain/';
            if(!preg_match($pattern_MDI,$logo) && !preg_match($pattern_dev,$logo)){
                return ResponseModel::err(1004,null,null,[
                    '参数' => '参数logo'
                ]);
            }
        }
        $color_classes = explode(' ',$request->color);
        foreach($color_classes as $color_class){
            if(!preg_match('/^wemd-[0-9a-z\-]+$/',$color_class)){
                return ResponseModel::err(1004,null,null,[
                    '参数' => '参数color'
                ]);
            }
        }
        return $next($request);
    }
}
