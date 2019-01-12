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



Route::get('/', 'SwitchboardController@index');
Route::get('/bydate/{startDate}/{endDate}', 'SwitchboardController@dateRange');
Route::get('/day/{day}', 'SwitchboardController@getDay');
Route::get('/datagraphs/{datagraphs}','SwitchboardController@getDataGraphs');



Route::group(['prefix' => 'agents'], function()
{
    Route::get('/', 'AgentController@index');

    Route::get('/{id}', 'AgentController@getById');


    Route::get('/{id}/{startDate}/{endDate}', 'AgentController@dateRange');

});


Route::group(['prefix' => 'customers'], function()
{
    Route::get('/', 'CustomerController@index');

    Route::get('/{id}', 'CustomerController@getById');

    Route::get('/{id}/{startDate}/{endDate}', 'CustomerController@dateRange');

});
