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

Route::get('search/function', 'SearchController@searchByFunction');
Route::get('search/functionNormalized', 'SearchController@searchByFunctionNormalized');
Route::get('search/city', 'SearchController@searchByCity');
Route::get('search/total_cities', 'SearchController@searchByTotalCities');

Route::post('search/function', 'SearchController@searchByFunction');
Route::post('search/city', 'SearchController@searchByCity');
Route::post('search/functionNormalized', 'SearchController@searchByFunctionNormalized');
Route::post('search/total_cities', 'SearchController@searchByTotalCities');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::post('save/city', 'GraphicController@storeCityGraphic');
Route::post('save/function', 'GraphicController@storeFunctionGraphic');
Route::post('save/functionNormalized', 'GraphicController@storeFunctionNormalizedGraphic');
Route::post('save/totalCities', 'GraphicController@storeTotalCitiesGraphic');

Route::post('erase/graphic', 'GraphicController@eraseGraphic');
Route::post('select/graphic', 'GraphicController@selectGraphic');
Route::get('select/graphic', 'GraphicController@selectGraphic');

Route::get('details/city', 'GraphicController@detailsCity');
Route::post('details/city', 'GraphicController@detailsCity');

Route::get('details/function', 'GraphicController@detailsFunction');
Route::post('details/function', 'GraphicController@detailsFunction');

Route::get('details/totalCity', 'GraphicController@detailsTotalCity');
Route::post('details/totalCity', 'GraphicController@detailsTotalCity');

Route::post('unsubscribe', 'UserController@unsubscribe');

Route::get('user', 'UserController@index');
