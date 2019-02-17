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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/welcome', 'HomeController@index');
Route::get('/about', 'HomeController@index');


# Parent Module
Route::group(['middleware' => 'auth', 'prefix' => 'parent'], function() {

	Route::get('/dashboard', 'ParentController@dashboard');

});


# Teachers module
Route::group(['middleware' => 'auth', 'prefix' => 'teacher'], function() {

	Route::get('/dashboard', 'TeacherController@dashboard');
	Route::get('/students/all', 'TeacherController@students');
	Route::get('/students', 'TeacherController@studentsByClass');
	Route::get('/students/upload', 'TeacherController@uploadStudentsPage');
	Route::post('/students/upload', 'TeacherController@uploadStudentsAction');

});


# SuperAdmin module
Route::group(['middleware' => 'auth', 'prefix' => 'super-admin'], function() {

	Route::get('/dashboard', 'AdminController@dashboard');

});
