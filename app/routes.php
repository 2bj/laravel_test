<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/',  function(){ return Redirect::to('/form'); });
Route::any('/form',  "FormController@showForm");

Route::get('/getCities',  "FormController@getCities");
Route::get('/captcha',  "FormController@getCaptcha");

Route::any('/backend/form',  "AdminController@loginForm");
Route::any('/backend',  function(){ return Redirect::to('/backend/form'); });
Route::any('/backend/user/login',  "AdminController@loginProcess");
Route::any('/backend/user/logout',  "AdminController@loguotProcess");
Route::any('/backend/email',  "AdminController@emailProcess");

Route::get('/backend/form/list',  "AdminController@listForm");
Route::get('/backend/form/{id}',  "AdminController@viewForm");
Route::any('/backend/form/{id}/edit',  "AdminController@editForm");
Route::get('/backend/form/{id}/delete',  "AdminController@deleteForm");
Route::post('/backend/form/checkOn',  "AdminController@checkOn");

//Route::post('/',  "FormController@saveForm"
//    /* function() { return View::make('layout'); } */
//);
