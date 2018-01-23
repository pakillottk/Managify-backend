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

Route::post( '/login', 'LoginController@login' );

Route::get( '/companies', 'CompanyController@index' )
->middleware( ['auth:api', 'allScopes:companies-read-allowed' ]);

Route::put('/companies/{id}', 'CompanyController@update' )
->middleware( ['auth:api', 'allScopes:companies-write-allowed' ]);

Route::post('/companies', 'CompanyController@store' )
->middleware( ['auth:api', 'allScopes:companies-write-allowed' ]);

Route::delete( '/companies/{id}', 'CompanyController@destroy' )
->middleware( ['auth:api', 'allScopes:companies-delete-allowed' ]);

Route::group([ 'middleware' => ['auth:api'] ], function() {
    Route::get('/roles', 'RoleController@index' );
    Route::post('/roles', 'RoleController@store' ); 
    Route::put('/roles/{id}', 'RoleController@update' );   
    Route::delete( '/roles/{id}', 'RoleController@destroy' );

    Route::get('/users', 'UserController@index' );
    Route::post('/users', 'UserController@store' ); 
    Route::put('/users/{id}', 'UserController@update' );   
    Route::delete( '/users/{id}', 'UserController@destroy' );

    Route::get('/permissions', 'PermissionController@index' );
    Route::post('/permissions', 'PermissionController@store' ); 
    Route::put('/permissions/{id}', 'PermissionController@update' );   
    Route::delete( '/permissions/{id}', 'PermissionController@destroy' );
});