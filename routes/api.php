<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::group([
    'prefix' => 'categories', 
    'controller'=>CategoryController::class, 
    'middleware'=>'auth:api'], function () {
    Route::get('/', 'index');
});
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
    Route::post('/seasons', 'storeSeason');
    Route::post('/seasons/{season_number}/episodes', 'storeEpisode');
    Route::get('/{tv_id}/seasons/{season_number}/episodes/{episode_number}', 'getEpisode');
});