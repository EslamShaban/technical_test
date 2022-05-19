<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;


Route::group(
    [
        'prefix'        => LaravelLocalization::setLocale(),
        'middleware'    => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function(){ 


        Route::name('admin.')->prefix('admin')->group(function(){

            //home
            Route::get('/', [HomeController::class,'index'])->name('index');

  
            //users
            Route::resource('users', UserController::class)->name('*','users');


        });

        
    });

    