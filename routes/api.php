<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TvShowController;


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
Route::group([
    'prefix' => 'auth',
    'controller' => AuthController::class,
], function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

/* 
Endpoint for retrieving movies. It should be allowed to filter and sort by some field.
Endpoint for retrieving the information (director included) of a specific episode of a TV Show
Endpoint for adding a new object (it could be for any entity you like).
*/
Route::group([
    'prefix' => 'movies', 
    'controller'=>MovieController::class, 
    'middleware'=>'auth:api'], function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
});
Route::group([
    'prefix' => 'tvshows', 
    'controller'=>TvShowController::class, 
    'middleware'=>'auth:api'], function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
});