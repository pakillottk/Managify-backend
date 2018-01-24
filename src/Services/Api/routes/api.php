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

//COMPANIES
Route::get( '/companies', 'CompanyController@index' )
->middleware( ['auth:api', 'allScopes:companies-read-allowed' ]);

Route::put('/companies/{id}', 'CompanyController@update' )
->middleware( ['auth:api', 'allScopes:companies-write-allowed' ]);

Route::post('/companies', 'CompanyController@store' )
->middleware( ['auth:api', 'allScopes:companies-write-allowed' ]);

Route::delete( '/companies/{id}', 'CompanyController@destroy' )
->middleware( ['auth:api', 'allScopes:companies-delete-allowed' ]);

//ROLES
Route::get('/roles', 'RoleController@index' )
->middleware( ['auth:api', 'allScopes:roles-read-allowed' ]);

Route::post('/roles', 'RoleController@store' )
->middleware( ['auth:api', 'allScopes:roles-write-allowed' ]);

Route::put('/roles/{id}', 'RoleController@update' )
->middleware( ['auth:api', 'allScopes:roles-write-allowed' ]);

Route::delete( '/roles/{id}', 'RoleController@destroy' )
->middleware( ['auth:api', 'allScopes:roles-delete-allowed' ]);

//USERS
Route::get('/users', 'UserController@index' )
->middleware( ['auth:api', 'allScopes:users-read-allowed' ]);

Route::post('/users', 'UserController@store' )
->middleware( ['auth:api', 'allScopes:users-write-allowed' ]);

Route::put('/users/{id}', 'UserController@update' )
->middleware( ['auth:api', 'allScopes:users-write-allowed' ]);

Route::delete( '/users/{id}', 'UserController@destroy' )
->middleware( ['auth:api', 'allScopes:users-delete-allowed' ]);

//PERMISSIONS
Route::get('/permissions', 'PermissionController@index' )
->middleware( ['auth:api', 'allScopes:permissions-read-allowed' ]);

Route::post('/permissions', 'PermissionController@store' )
->middleware( ['auth:api', 'allScopes:permissions-write-allowed' ]);

Route::put('/permissions/{id}', 'PermissionController@update' )
->middleware( ['auth:api', 'allScopes:permissions-write-allowed' ]);

Route::delete( '/permissions/{id}', 'PermissionController@destroy' )
->middleware( ['auth:api', 'allScopes:permissions-delete-allowed' ]);
