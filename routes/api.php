<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['Lang','APIAuth','api'])->group(function(){

    Route::prefix('auth')->group(function () {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('forget_password', [AuthController::class, 'forget_password']);   
    });



    Route::middleware(['JwtApiAuth'])->group(function () {
             
        Route::post('update_profile', [AuthController::class, 'update_profile']);
        Route::post('logout', [AuthController::class, 'logout']);

               
        Route::prefix('product')->group(function(){
        
            Route::post('add', [ProductController::class, 'add_product']);
            Route::post('{id}/update', [ProductController::class, 'update_product']);
            Route::delete('{id}/delete', [ProductController::class, 'delete_product']);
            Route::post('send', [ProductController::class, 'send_product_info']);
            Route::get('my_products', [ProductController::class, 'my_products']);
            Route::get('all', [ProductController::class, 'all_products']);

        });
    });

});