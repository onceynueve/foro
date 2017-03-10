<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('register', 
	       ['uses'=>'RegisterController@create',
	       'as'=>'register']
	       );

Route::post('register', 
	       ['uses'=>'RegisterController@store']
	       );

Route::get('login', 
	       ['uses'=>'LoginController@create',
	       'as'=>'login']
	       );

Route::post('login', 
	       ['uses'=>'LoginController@store',
	       'as'=>'login']
	       );
