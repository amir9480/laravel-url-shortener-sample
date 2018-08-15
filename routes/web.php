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

Route::get('/', 'LinkController@show');
Route::post('/request-link', 'LinkController@requestLink')->name("request_link");
Route::get('/o/{slug}', 'LinkController@openLink')->name("open_link");
