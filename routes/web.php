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

Route::auth();
Auth::routes();
Route::get('/','Main\loginController@index');

//Registrar Main
Route::get('/registrar/viewstudentprofile/{idno}','Registrar\Main\StudentProfile@index');
Route::get('/registrar/printstudentprofile/{idno}', 'Registrar\Main\StudentProfile@printProfile');
Route::get('/registrar/viewgrades/{idno}', 'Registrar\Main\StudentProfile@viewGrades');
//Student Profile
Route::post('/registrar/update_profile', 'Registrar\Main\StudentProfile@update');

//Registrar Assessment
Route::get('/registrar/viewinfo/{idno}','Registrar\Assessment\AssessmentController@viewinfo');
Route::get('/registrar/assess_payment/{idno}','Registrar\Assessment\AssessmentController@viewassessment');
Route::get('/registrar/assessment/college','Registrar\Assessment\AssessmentController@indexcollege');
Route::get('/registrar/assessment/shs','Registrar\Assessment\AssessmentController@indexshs');

//ajax assessment
Route::get('/registrar/ajax/assessment/computePayment', 'Registrar\Ajax\paymentAssessment@computePayment');
Route::get('/registrar/ajax/assessment/computePaymentshs', 'Registrar\Ajax\paymentAssessmentSHS@computePayment');
Route::get('/registrar/ajax/assessmentcollege/getmainstudentlist','Registrar\Main\AjaxController@getmainstudentlistassessmentcollege');
Route::get('/registrar/ajax/assessmentshs/getmainstudentlist','Registrar\Main\AjaxController@getmainstudentlistassessmentshs');
Route::get('/registrar/ajax/addtogradeshs/{level}/{track}', 'Registrar\Ajax\paymentAssessmentSHS@addtograde_shs');
Route::get('/registrar/ajax/removegradeshs/{id}', 'Registrar\Ajax\paymentAssessmentSHS@removegradeshs');

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
Route::get('/registrar/course_scheduling_list_shs/{id}','Registrar\CourseSchedule\SHSCourseSchedule@listcourseschedule');

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
Route::get('/registrar/ajax/shs/getlist/{track}/{curriculum_year}/{level}','Registrar\Ajax\shsCourseOffering@getList');
Route::get('/registrar/ajax/shs/getcourseoffered/{track}/{curriculum_year}/{level}/{section}','Registrar\Ajax\shsCourseOffering@getCourseOffered');
Route::get('/registrar/ajax/shs/getsubject/{track}/{curriculum_year}/{level}/{section}/{course_code}','Registrar\Ajax\shsCourseOffering@getSubject');
Route::get('/registrar/ajax/shs/removesubject/{id}','Registrar\Ajax\shsCourseOffering@removeSubject');
Route::get('/registrar/ajax/shs/addallsubjects','Registrar\Ajax\shsCourseOffering@addAllSubjects');
Route::get('/registrar/ajax/shs/getyearsection/{track}','Registrar\Ajax\shsCourseSchedule@getcourses');
Route::get('/registrar/ajax/shs_course_offering/getsection/{level}', 'Registrar\Ajax\shsCourseOffering@getsection');

//ajax resistrar course offering
Route::get('/registrar/ajax/addschedule_college','Registrar\Ajax\collegeCourseSchedule@addschedule');
Route::get('/registrar/ajax/changeroom_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changeroom');
Route::get('/registrar/ajax/changeday_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changeday');
Route::get('/registrar/ajax/changetime_start_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changetime_start');
Route::get('/registrar/ajax/changetime_end_college/{sched_id}/{value}','Registrar\Ajax\collegeCourseSchedule@changetime_end');
Route::get('/registrar/ajax/deletesched_college/{sched_id}','Registrar\Ajax\collegeCourseSchedule@deletesched');
Route::get('/registrar/ajax/room/autocomplete','Registrar\Ajax\collegeCourseSchedule@getlistroom');
//shs
Route::get('/registrar/ajax/addschedule_shs','Registrar\Ajax\shsCourseSchedule@addschedule');
Route::get('/registrar/ajax/getexistingsched_shs/{room}','Registrar\Ajax\shsCourseSchedule@getexistingsched');
Route::get('/registrar/ajax/changeroom_shs/{sched_id}/{value}','Registrar\Ajax\shsCourseSchedule@changeroom');
Route::get('/registrar/ajax/changeday_shs/{sched_id}/{value}','Registrar\Ajax\shsCourseSchedule@changeday');
Route::get('/registrar/ajax/changetime_start_shs/{sched_id}/{value}','Registrar\Ajax\shsCourseSchedule@changetime_start');
Route::get('/registrar/ajax/changetime_end_shs/{sched_id}/{value}','Registrar\Ajax\shsCourseSchedule@changetime_end');
Route::get('/registrar/ajax/deletesched_shs/{sched_id}','Registrar\Ajax\shsCourseSchedule@deletesched');
Route::get('/registrar/ajax/room/autocomplete_shs','Registrar\Ajax\shsCourseSchedule@getlistroom');

//ajax registrar course schedule
Route::get('/registrar/ajax/shs_course_schedule/getsection/{level}','Registrar\Ajax\shsCourseSchedule@getsection');
Route::get('/registrar/ajax/getyearsection_shs/{track}','Registrar\Ajax\shsCourseSchedule@getcourses');

//ajax registrar assign instructor
Route::get('/registrar/ajax/get_courseoffering_college','Registrar\Ajax\collegeAssignInstructor@getcourses');
Route::get('/registrar/ajax/add_coursetoinstructor_college/{id}','Registrar\Ajax\collegeAssignInstructor@addcourses');
Route::get('/registrar/ajax/remove_coursetoinstructor_college/{id}','Registrar\Ajax\collegeAssignInstructor@removecourses');
//shs
Route::get('/registrar/ajax/get_courseoffering_shs','Registrar\Ajax\shsAssignInstructor@getcourses');
Route::get('/registrar/ajax/add_coursetoinstructor_shs/{id}','Registrar\Ajax\shsAssignInstructor@addcourses');
Route::get('/registrar/ajax/remove_coursetoinstructor_shs/{id}','Registrar\Ajax\shsAssignInstructor@removecourses');
Route::get('/registrar/ajax/loadsubjects_shs/getsection/{level}/{track}', 'Registrar\Ajax\shsAssignInstructor@getlevel');

//registrar payment_assessment
Route::post('/registrar/process_payment','Registrar\Assessment\processPayment@index');
Route::get('/registrar/registration/{idno}', 'Registrar\Assessment\registrationController@index');

Route::get('/registrar/reassess/{idno}', 'Registrar\Assessment\registrationController@reassess');
Route::get('/registrar/print_registration_form/{idno}', 'Registrar\Assessment\registrationController@printform');

//registrar assess subject
Route::get('/registrar/assess_subject/{idno}', 'Registrar\Main\ViewStudentStatus@index');
Route::post('/registrar/main/selectsubjectcollege','Registrar\Main\SelectSubject@college');
Route::post('/registrar/main/selectsubjectshs','Registrar\Main\SelectSubject@shs');
Route::post('/registrar/main/registersubjects','Registrar\Main\RegisterSubjects@index');

//registrar import grades
Route::get('/registrar/import_grades/college','Registrar\Grades\ImportGrades@college');
Route::post('/importExcelCollege', 'Registrar\Grades\ImportGrades@importExcelCollege');
Route::post('/saveentry_college', 'Registrar\Grades\ImportGrades@saveExcelCollege');
Route::get('/registrar/import_grades/shs','Registrar\Grades\ImportGrades@shs');
Route::post('/importExcelSHS', 'Registrar\Grades\ImportGrades@importExcelSHS');
Route::post('/saveentry_shs', 'Registrar\Grades\ImportGrades@saveExcelSHS');

//registrar sectioning
Route::get('/setup_sectioning/shs', 'Registrar\Sectioning\SetupSections@shsindex');
Route::get('/ajax/sectioning_shs/{level}/{track}', 'Registrar\Sectioning\Ajax\AjaxController@getLevel');
Route::get('/ajax/sectioning_list/{level}/{track}', 'Registrar\Sectioning\Ajax\AjaxController@getStudentList');
Route::get('/ajax/sectioning_sectioninglist/{section}/{level}', 'Registrar\Sectioning\Ajax\AjaxController@getSectionList');
Route::get('/ajax/sectioning/addtosection/{idno}', 'Registrar\Sectioning\Ajax\AjaxController@addtosection');
Route::get('/ajax/sectioning/removetosection/{idno}', 'Registrar\Sectioning\Ajax\AjaxController@removetosection');
Route::get('/ajax/sectioning/assignadviser/{adviser}', 'Registrar\Sectioning\Ajax\AjaxController@assignadviser');

//registrar report
Route::get('/registrar/reports/enrollment_report', 'Registrar\Reports\reportsController@enrollment_report');
Route::post('/registrar/reports/generate_enrollmentreport', 'Registrar\Reports\reportsController@generate_enrollmentreport');
Route::get('/registrar/reports/enrollment_statistics', 'Registrar\Reports\enrollmentStatistics@index');

//adding dropping
Route::get('/registrar/adding_dropping','Registrar\Grades\AddingDroppingController@index');
Route::get('/registrar/adding_dropping/{idno}','Registrar\Grades\AddingDroppingController@viewprofile');
Route::get('/registrar/ajax/adding_dropping/getmainstudentlist','Registrar\Grades\Ajax\adding_dropping@getmainstudentlist');
Route::get('/registrar/ajax/adding_course/{id}','Registrar\Grades\Ajax\adding_dropping@addcourse');
Route::get('/registrar/ajax/drop_course/{id}','Registrar\Grades\Ajax\adding_dropping@dropcourse');

//manual changing of grades
Route::get('/registrar/manualchange_college', 'Registrar\Grades\ManualChanges@college');
Route::get('/ajax/manualchange_college/displaysubjects/{idno}', 'Registrar\Grades\Ajax\manualchanges@listsubjectcollege');
Route::get('/ajax/manualchange_college/prelim/{id}/{grade}', 'Registrar\Grades\Ajax\manualchanges@changeprelim');
Route::get('/ajax/manualchange_college/midterm/{id}/{grade}', 'Registrar\Grades\Ajax\manualchanges@changemidterm');
Route::get('/ajax/manualchange_college/final/{id}/{grade}', 'Registrar\Grades\Ajax\manualchanges@changefinal');
Route::get('/registrar/liststudents/manualchange_college/{id}', 'Registrar\Grades\ManualChanges@liststudents_college');
Route::get('/registrar/manualchange_shs');

//studentlist
Route::get('/registrar/studentlist_college','Registrar\Main\StudentList@college');
Route::get('/registrar/studentlist_shs','Registrar\Main\StudentList@shs');
Route::get('/registrar/generatereport/studentlist/{course_offering_id}', 'Registrar\Main\StudentList@printStudentlist_college');
//studentlist ajax
Route::get('/registrar/ajax/studentlist/getsubjectlistcollege','Registrar\Ajax\GetSubjectList@getlistcollege');
Route::get('/registrar/ajax/studentlist/getsubjectlistpersearchcollege','Registrar\Ajax\GetSubjectList@getlistpersearchcollege');
Route::get('/registrar/ajax/studentlist/getsubjectlistshs','Registrar\Ajax\GetSubjectList@getlistshs');
Route::get('/registrar/ajax/studentlist/getsubjectlistpersearchshs','Registrar\Ajax\GetSubjectList@getlistpersearchshs');
