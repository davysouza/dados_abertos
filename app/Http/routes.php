<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PagesController@index');
Route::get('search', 'PagesController@search');

//Route::get('search/function', 'SearchController@searchByFunction');

Route::post('search/function', 'SearchController@searchByFunction');
Route::post('search/city', 'SearchController@searchByCity');
