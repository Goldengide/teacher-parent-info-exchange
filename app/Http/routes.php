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
// Route::post('/login', 'LoginController@loginPost');


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

	Route::get('/students/new', 'TeacherController@addStudentPage');
	Route::post('/students/new', 'TeacherController@addStudentAction');

	Route::get('/students/edit/{id}', 'TeacherController@updateStudentPage');
	Route::post('/students/edit', 'TeacherController@updateStudentAction');

});


# SuperAdmin module
Route::group(['middleware' => 'auth', 'prefix' => 'super-admin'], function() {

	Route::get('/dashboard', 'AdminController@dashboard');

	Route::get('/teacher/new', 'AdminController@newTeacherPage');
	Route::post('/teacher/add', 'AdminController@newTeacherAction');
	Route::get('/parent/new', 'AdminController@newParentPage');
	Route::post('/parent/add', 'AdminController@newParentAction');

	Route::get('/teacher/edit/{id}', 'AdminController@updateTeacherPage');
	Route::post('/teacher/edit', 'AdminController@updateTeacherAction');
	Route::get('/parent/edit/{id}', 'AdminController@updateParentPage');
	Route::post('/parent/edit', 'AdminController@updateParentAction');

	Route::get('/teacher/profile/{id}', 'AdminController@teacherProfile');
	Route::get('/parent/profile/{id}', 'AdminController@parentProfile');

	Route::get('/teachers', 'AdminController@teachers');
	Route::get('/parents', 'AdminController@parents');

	Route::get('/teacher/upload', 'AdminController@uploadTeachersPage');
	Route::post('/teacher/upload', 'AdminController@uploadTeachersAction');
	Route::get('/student/upload/{id}', 'AdminController@uploadParentPage');
	Route::post('/student/upload', 'AdminController@uploadParentAction');
	Route::get('/parent/extract', 'AdminController@extractParent');


	// Classes Upload 
	Route::get('/classes', 'AdminController@classes');
	Route::get('/classes/new', 'AdminController@addClass');
	Route::post('/classes/new', 'AdminController@addClassAction');
	Route::get('/classes/edit/{id}', 'AdminController@editClass');
	Route::post('/classes/edit', 'AdminController@editClassAction');
	Route::get('classes/upload', 'AdminController@classesUploadPage');
	Route::post('/classes/upload', 'AdminController@classesUpload');


	// Subject Upload 
	Route::get('/subjects', 'AdminController@subjects');
	Route::get('/subject/new', 'AdminController@addSubject');
	Route::post('/subject/new', 'AdminController@addSubjectAction');
	Route::get('/subject/edit/{id}', 'AdminController@editSubject');
	Route::get('/subject/edit', 'AdminController@editSubjectAction');
	Route::get('subject/upload', 'AdminController@uploadSubjectsPage');
	Route::post('/subject/upload', 'AdminController@uploadSubjects');


	// Seasons Upload

	Route::get('/seasons', 'SeasonController@index');
	Route::get('/seasons/generate/{start}/{stop}', 'SeasonController@generateSeasonsFromIntervals');
	Route::get('/seasons/generator', 'SeasonController@generateSeasonsInterface');
	Route::post('/seasons/generator', 'SeasonController@generateSeasonsAction');
	Route::get('/seasons/clear', 'SeasonController@clearSeason');
	Route::get('/season/activate/{id}', 'SeasonController@activate');
	Route::get('/season/make-current/{id}', 'SeasonController@makeCurrent');


});
