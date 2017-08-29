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
include_once 'web3.php';

Route::auth();
Auth::routes();
Route::get('/','Main\loginController@index');

//Registrar Assessment
Route::get('/registrar/viewinfo/{idno}','Registrar\Assessment\AssessmentController@viewinfo');
Route::get('/registrar/assess_payment/{idno}','Registrar\Assessment\AssessmentController@viewassessment');
Route::get('/registrar/assessment/college','Registrar\Assessment\AssessmentController@indexcollege');
Route::get('/registrar/assessment/shs','Registrar\Assessment\AssessmentController@indexshs');

//ajax assessment
Route::get('/registrar/ajax/assessment/computePayment', 'Registrar\Ajax\paymentAssessment@computePayment');
Route::get('/registrar/ajax/assessmentcollege/getmainstudentlist','Registrar\Main\AjaxController@getmainstudentlistassessmentcollege');
Route::get('/registrar/ajax/assessmentshs/getmainstudentlist','Registrar\Main\AjaxController@getmainstudentlistassessmentshs');

//Registrar Curriculum
Route::get('/registrar/view_curriculum/college','Registrar\Curriculum\CollegeCurriculumController@curriculum');
Route::get('/registrar/list_curricula/college/{program_code}','Registrar\Curriculum\CollegeCurriculumController@list_curricula');
Route::get('/registrar/curriculum/college/{curriculum_year}/{program_code}','Registrar\Curriculum\CollegeCurriculumController@viewcurriculum');
//shs
Route::get('/registrar/view_curriculum/shs','Registrar\Curriculum\SHSCurriculumController@curriculum');
Route::get('/registrar/list_curricula/shs/{track}','Registrar\Curriculum\SHSCurriculumController@list_curricula');
Route::get('/registrar/curriculum/shs/{curriculum_year}/{track}','Registrar\Curriculum\SHSCurriculumController@viewcurriculum');

//Registrar Course Offering
Route::get('/registrar/course_offering/college', 'Registrar\CourseOffering\CollegeCourseOfferingController@index');
Route::get('/registrar/view_course_offering/college/{program_code}', 'Registrar\CourseOffering\CollegeCourseOfferingController@view');
//shs
Route::get('/registrar/course_offering/shs', 'Registrar\CourseOffering\SHSCourseOfferingController@index');
Route::get('/registrar/view_course_offering/shs/{track}', 'Registrar\CourseOffering\SHSCourseOfferingController@view');

//Registrar Course Schedule
Route::get('/registrar/course_scheduling/college','Registrar\CourseSchedule\CollegeCourseSchedule@index');
Route::get('/registrar/course_scheduling_list/{id}','Registrar\CourseSchedule\CollegeCourseSchedule@listcourseschedule');
//shs
Route::get('/registrar/course_scheduling/shs','Registrar\CourseSchedule\SHSCourseSchedule@index');

//Registrar Assign Instructor
Route::get('/registrar/assign_instructor/college', 'Registrar\AssignInstructor\CollegeAssignInstructorController@index');
Route::get('/registrar/assign_instructor/view_profile_college/{id}', 'Registrar\AssignInstructor\CollegeAssignInstructorController@viewprofile');
Route::get('/registrar/assign_instructor/loadsubjects_college/{id}', 'Registrar\AssignInstructor\CollegeAssignInstructorController@loadsubjects');
Route::get('/registrar/assign_instructor/modify_college/{id}', 'Registrar\AssignInstructor\CollegeAssignInstructorController@viewmodify');
Route::post('/registrar/assign_instructor/modifyinfo_college', 'Registrar\AssignInstructor\CollegeAssignInstructorController@modifyinfo');
//shs
Route::get('/registrar/assign_instructor/shs', 'Registrar\AssignInstructor\SHSAssignInstructorController@index');
Route::get('/registrar/assign_instructor/view_profile_shs/{id}', 'Registrar\AssignInstructor\SHSAssignInstructorController@viewprofile');
Route::get('/registrar/assign_instructor/loadsubjects_shs/{id}', 'Registrar\AssignInstructor\SHSAssignInstructorController@loadsubjects');
Route::get('/registrar/assign_instructor/modify_shs/{id}', 'Registrar\AssignInstructor\SHSAssignInstructorController@viewmodify');
Route::post('/registrar/assign_instructor/modifyinfo_shs', 'Registrar\AssignInstructor\SHSAssignInstructorController@modifyinfo');

//Guidance
Route::get('/guidance/newstudent','Guidance\Admission\NewStudentController@newstudent');
Route::get('/guidance/newstudent_shs','Guidance\Admission\NewStudentController@newstudent_shs');
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

//ajax guidance routes
Route::get('/guidance/ajax/getmainstudentlist','Guidance\Main\AjaxController@getmainstudentlist');
Route::get('/guidance/ajax/getexamschedule/', 'Guidance\Main\AjaxController@getexamschedule');
Route::get('/guidance/ajax/getexambatch/', 'Guidance\Main\AjaxController@getexambatch');
Route::get('/guidance/ajax/changevalue/{idno}/{value}', 'Guidance\Main\AjaxController@changevalue');
Route::get('/guidance/ajax/getacademicprogram/{acad_type}', 'Guidance\Main\AjaxController@getacademicprogram');
Route::get('/guidance/ajax/getacad_prog/{acad_type}/{acad_prog}', 'Guidance\Main\AjaxController@getacad_prog');

//ajax registrar routes
Route::get('/registrar/ajax/getmainstudentlist','Registrar\Main\AjaxController@getmainstudentlist');
Route::get('/registrar/ajax/getlist/{program_code}/{curriculum_year}/{period}/{level}','Registrar\Ajax\collegeCourseOffering@getList');
Route::get('/registrar/ajax/getcourseoffered/{program_code}/{curriculum_year}/{period}/{level}/{section}','Registrar\Ajax\collegeCourseOffering@getCourseOffered');
Route::get('/registrar/ajax/getsubject/{program_code}/{curriculum_year}/{period}/{level}/{section}/{course_code}','Registrar\Ajax\collegeCourseOffering@getSubject');
Route::get('/registrar/ajax/removesubject/{id}','Registrar\Ajax\collegeCourseOffering@removeSubject');
Route::get('/registrar/ajax/addallsubjects','Registrar\Ajax\collegeCourseOffering@addAllSubjects');
Route::get('/registrar/ajax/getyearsection/{program_code}','Registrar\Ajax\collegeCourseSchedule@getcourses');
Route::get('/registrar/ajax/getexistingsched/{room}','Registrar\Ajax\collegeCourseSchedule@getexistingsched');
//shs
Route::get('/registrar/ajax/getlist/shs/{track}/{curriculum_year}/{period}/{level}','Registrar\Ajax\shsCourseOffering@getList');
Route::get('/registrar/ajax/getcourseoffered/shs/{track}/{curriculum_year}/{period}/{level}/{section}','Registrar\Ajax\shsCourseOffering@getCourseOffered');
Route::get('/registrar/ajax/getsubject/shs/{track}/{curriculum_year}/{period}/{level}/{section}/{course_code}','Registrar\Ajax\shsCourseOffering@getSubject');
Route::get('/registrar/ajax/removesubject/shs/{id}','Registrar\Ajax\shsCourseOffering@removeSubject');
Route::get('/registrar/ajax/addallsubjects/shs','Registrar\Ajax\shsCourseOffering@addAllSubjects');
Route::get('/registrar/ajax/getyearsection/shs/{track}','Registrar\Ajax\shsCourseSchedule@getcourses');

//ajax resistrar course offering
Route::get('/registrar/ajax/addschedule_college','Registrar\Ajax\collegeCourseSchedule@addschedule');
Route::get('/registrar/ajax/changeroom_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changeroom');
Route::get('/registrar/ajax/changeday_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changeday');
Route::get('/registrar/ajax/changetime_start_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changetime_start');
Route::get('/registrar/ajax/changetime_end_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changetime_end');
Route::get('/registrar/ajax/deletesched_college/{sched_id}','Registrar\Ajax\collegeCourseSchedule@deletesched');
Route::get('/registrar/ajax/room/autocomplete','Registrar\Ajax\collegeCourseSchedule@getlistroom');

//ajax registrar assign instructor
Route::get('/registrar/ajax/get_courseoffering_college','Registrar\Ajax\collegeAssignInstructor@getcourses');
Route::get('/registrar/ajax/add_coursetoinstructor_college/{id}','Registrar\Ajax\collegeAssignInstructor@addcourses');
Route::get('/registrar/ajax/remove_coursetoinstructor_college/{id}','Registrar\Ajax\collegeAssignInstructor@removecourses');
//shs
Route::get('/registrar/ajax/get_courseoffering_shs','Registrar\Ajax\shsAssignInstructor@getcourses');
Route::get('/registrar/ajax/add_coursetoinstructor_shs/{id}','Registrar\Ajax\shsAssignInstructor@addcourses');
Route::get('/registrar/ajax/remove_coursetoinstructor_shs/{id}','Registrar\Ajax\shsAssignInstructor@removecourses');

//registrar payment_assessment
Route::post('/registrar/process_payment','Registrar\Assessment\processPayment@index');
Route::get('/registrar/registration/{idno}', 'Registrar\Assessment\registrationController@index');

Route::get('/registrar/reassess/{idno}', 'Registrar\Assessment\registrationController@reassess');
Route::get('/registrar/print_registration_form/{idno}', 'Registrar\Assessment\registrationController@printform');
