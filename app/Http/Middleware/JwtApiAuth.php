<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
class JwtApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
                
        try {

            $token = JWTAuth::parseToken()->toUser();

            return $token ? $next( $request ) : response()->withError(__('api.unauthorize'),5000);
        }
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->withError(__('api.unauthorize'),5000);

        }
    }
}
