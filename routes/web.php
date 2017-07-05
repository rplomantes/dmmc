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


Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/ajax/college/getcurriculum','Registrar\Main\AjaxController@getCurriculum');

Route::auth();
Auth::routes();
Route::get('/','Main\loginController@index');

//Registrar
Route::get('/registrar/profile','\mainController@profile');
Route::get('/registrar/curriculum/college','Registrar\College\curriculumController@index');
Route::get('/registrar/curriculum/college/add','Registrar\College\curriculumController@add');
Route::post('/registrar/curriculum/addcurriculum','Registrar\College\curriculumController@addcurriculum');

//Guidance
Route::get('/guidance/newstudent','Guidance\Admission\NewStudentController@newstudent');
Route::post('/guidance/addapplicant','Guidance\Admission\NewStudentController@addapplicant');
Route::get('/guidance/list_of_applicants','Guidance\Admission\ListApplicantsController@listApplicants');
Route::get('/guidance/viewinfo/{idno}','Guidance\Admission\ListApplicantsController@viewinfo');
Route::post('/guidance/schedule_applicant','Guidance\Admission\ExamScheduleController@schedApplicant');

//ajax routes
Route::get('/ajax/getmainstudentlist','Guidance\Main\AjaxController@getmainstudentlist');
Route::get('/ajax/guidance/getMajor/{course}','Guidance\Main\AjaxController@getMajor');
Route::get('/ajax/guidance/getMajor2/{course2}','Guidance\Main\AjaxController@getMajor2');