<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *s
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,String $role)
    {
        // $roles = [
        //     'admin' => [1],
        //     'user' => [2]
        // ];

        // $roleIds = $roles[$role] ?? [];
        // echo auth()->user;
        // if(!in_array(auth()->user()->user_type_id ,$roleIds)){
        //     abort(403);
        // }
        
        if(auth()->user()->user_type != $role){
            abort(403);
        }
        return $next($request);
    }
}
