<?php

namespace App\Http\Middleware\Organization;

use App\Models\Eloquents\Organization;
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
        $organization_name = $request->organization_name;
        $organization = Organization::where('name',$organization_name)->first();
        if(empty($organization)) {
            if($request->isMethod('get')){
                return redirect($request->ATSAST_DOMAIN.route('home'));
            }else{
                return ResponseModel::err(5001);
            }
        }
        $request->merge([
            'organization' => $organization
        ]);
        return $next($request);
    }
}
