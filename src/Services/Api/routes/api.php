<?php

/*
|--------------------------------------------------------------------------
| Service - API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for this service.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Prefix: /api/api
Route::group(['prefix' => ''], function() {

    // The controllers live in src/Services/Api/Http/Controllers
    // Route::get('/', 'UserController@index');

    Route::get('/', function() {
        return response()->json(['path' => '/api/api']);
    });
    
    Route::get('/companies', 'CompanyController@index' );
    Route::post('/companies', 'CompanyController@store' ); 
    Route::put('/companies/{id}', 'CompanyController@update' );   
    Route::delete( '/companies/{id}', 'CompanyController@destroy' );

    Route::get('/roles', 'RoleController@index' );
    Route::post('/roles', 'RoleController@store' ); 
    Route::put('/roles/{id}', 'RoleController@update' );   
    Route::delete( '/roles/{id}', 'RoleController@destroy' );

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

});