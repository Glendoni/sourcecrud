<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/tests', function () {
    return ['Hello world'];
});
Route::resource('products', 'App\Http\Controllers\ProductController');
Route::resource('/orders', 'App\Http\Controllers\OrderController');
Route::resource('orderitems', 'App\Http\Controllers\OrderItemController');
Route::resource('projects', 'App\Http\Controllers\ProjectController');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
