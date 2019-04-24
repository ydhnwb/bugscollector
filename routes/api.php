<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::apiResource('bugs','Bug\BugController');

Route::post('bugs','Bug\BugController@store');
Route::get('bugs','Bug\BugController@index');
Route::post('bugs/{id}','Bug\BugController@update');
Route::get('bugs/{id}','Bug\BugController@show');
Route::delete('bugs/{id}', 'Bug\BugController@destroy');
Route::post('bugs/search/result', 'Bug\BugController@search');


Route::get('/news','NewsController@index');
Route::post('/news','NewsController@store');
Route::get('news/{id}','NewsController@show');
Route::post('news/search/result', 'NewsController@search');
