<?php
/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Ajax routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "ajax" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/

//Dean
Route::get('/ajax/getmainstudentlist','Dean\Main\AjaxController@getmainstudentlist');

//Registrar
Route::get('/ajax/getmainstudentlistregistrar','Registrar\Main\AjaxController@getmainstudentlistregistrar');