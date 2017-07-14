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
include_once 'web2.php';
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
Route::get('/guidance/exam_sched_creator','Guidance\Admission\ExamSchedCreatorController@createSched');
Route::get('/guidance/viewmodifyinfo/{idno}', 'Guidance\Admission\ListApplicantsController@viewmodifyinfo');
Route::post('/guidance/modifyinfo', 'Guidance\Admission\ListApplicantsController@modifyinfo');
Route::get('/guidance/schedule_applicant/{idno}','Guidance\Admission\ExamScheduleController@schedule');
Route::post('/guidance/schedApplicant','Guidance\Admission\ExamScheduleController@schedApplicant');


Route::get('/guidance/admission_slip/{idno}','Guidance\Admission\ExamScheduleController@printAdmission');
Route::get('/guidance/addexamsched','Guidance\Admission\ExamSchedCreatorController@addexamsched');
Route::post('/guidance/addsched','Guidance\Admission\ExamSchedCreatorController@addsched');
Route::get('/guidance/delete_examsched/{id}', 'Guidance\Admission\ExamSchedCreatorController@deletesched');
Route::get('/guidance/view_examsched/{id}','Guidance\Admission\ExamSchedCreatorController@viewmodifysched');
Route::post('/guidance/updatesched','Guidance\Admission\ExamSchedCreatorController@updatesched');
Route::get('/guidance/viewbatch/{id}', 'Guidance\Admission\ExamResultController@viewlist');

Route::get('/guidance/reports','Guidance\Admission\reportsController@index');
Route::post('/guidance/generate_report', 'Guidance\Admission\reportsController@generate');

//ajax routes
Route::get('/ajax/getmainstudentlist','Guidance\Main\AjaxController@getmainstudentlist');
Route::get('/ajax/getexamschedule/', 'Guidance\Main\AjaxController@getexamschedule');
Route::get('/ajax/getexambatch/', 'Guidance\Main\AjaxController@getexambatch');
Route::get('/ajax/changevalue/{idno}/{value}', 'Guidance\Main\AjaxController@changevalue');
Route::get('/ajax/getacademicprogram/{acad_type}', 'Guidance\Main\AjaxController@getacademicprogram');
Route::get('/ajax/getacad_prog/{acad_type}/{acad_prog}', 'Guidance\Main\AjaxController@getacad_prog');
