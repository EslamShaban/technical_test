<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        ResponseFactory::macro('withError', function($msg, $code, $data = null){

            return response()->json([
                'success' => false,
                'code' => $code,
                'msg' => $msg,
                'data' => $data
    
            ]);
        });

        ResponseFactory::macro('withSuccess', function($msg ='', $code = 200, $data = null){

            return response()->json([
                'success' => true,
                'code' => $code,
                'msg' => $msg,
                'data' => $data
            ]);

        });

        ResponseFactory::macro('withData', function($msg = "", $data = null, $code = 200){

            return response()->json([
                'success' => true,
                'code' => $code,
                'msg' => $msg,
                'data' => $data
            ]);

        });
    }
}
