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

Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
    Route::get('sections', 'SectionController@index');
    Route::get('sections/{id}', 'SectionController@show');
    Route::post('sections', 'SectionController@store');
    Route::put('sections/{id}', 'SectionController@update');
    Route::delete('sections/{id}', 'SectionController@destroy');

    Route::get('tasks', 'TaskController@index');
    Route::post('tasks', 'TaskController@store');
});
