<?php
//Dean
Route::get('/dean/viewstudentstatus/{idno}','Dean\Main\ViewStudentStatus@index');
Route::get('/dean/viewstudentprofile/{idno}','Dean\Main\StudentProfile@index');
Route::post('/dean/main/selectsubjectcollege','Dean\Main\SelectSubject@college');
Route::post('/dean/main/selectsubjectshs','Dean\Main\SelectSubject@shs');
Route::post('/dean/main/registersubjects','Dean\Main\RegisterSubjects@index');
//Ajax Dean
Route::get('/ajax/getdeanstudentlist','Dean\Ajax\GetStudentListController@index');
Route::get('/ajax/assessment/getdeanstudentlistcollege','Dean\Ajax\GetStudentListController@assessmentcollege');
Route::get('/ajax/assessment/getdeanstudentlistshs','Dean\Ajax\GetStudentListController@assessmentshs');
Route::get('/dean/ajax/getofferingpersection','Dean\Ajax\GetOfferingPersection@index');
Route::get('/dean/ajax/addtogradecollege','Dean\Ajax\AddToGradeCollege@index');
Route::get('/dean/ajax/removesubject','Dean\Ajax\AddToGradeCollege@removesubject');
Route::get('/dean/ajax/addallsubjects','Dean\Ajax\GetOfferingPersection@addallsubjects');
Route::get('/dean/ajax/getofferingpersearch','Dean\Ajax\GetOfferingPersection@search');
Route::get('/dean/ajax/getofferingpersearchshs','Dean\Ajax\GetOfferingPersection@searchshs');
Route::get('/dean/ajax/getofferingpersectionshs','Dean\Ajax\GetOfferingPersection@shs');
Route::get('/dean/ajax/addtogradeshs','Dean\Ajax\AddToGradeCollege@shs');
Route::get('/dean/ajax/removesubjectshs','Dean\Ajax\AddToGradeCollege@removesubjectshs');
Route::get('/dean/ajax/addallsubjectsshs','Dean\Ajax\GetOfferingPersection@addallsubjectsshs');

//studentlist
Route::get('/dean/studentlist','Dean\Main\StudentList@index');
Route::get('/dean/generatereport/studentlist/{course_offering_id}', 'Dean\Main\StudentList@printStudentlist');
Route::get('/dean/generatereport/studentlistshs/{course_offering_id}', 'Dean\Main\StudentList@printStudentlistshs');

//studentlist ajax
Route::get('/dean/ajax/studentlist/getsubjectlistcollege','Dean\Ajax\GetSubjectList@getlistcollege');
Route::get('/dean/ajax/studentlist/getsubjectlistpersearchcollege','Dean\Ajax\GetSubjectList@getlistpersearchcollege');
Route::get('/dean/ajax/studentlist/getsubjectlistshs','Dean\Ajax\GetSubjectList@getlistshs');
Route::get('/dean/ajax/studentlist/getsubjectlistpersearchshs','Dean\Ajax\GetSubjectList@getlistpersearchshs');

//dean assessment
Route::get('/dean/assessment/college','Dean\Assessment\AssessmentController@indexcollege');
Route::get('/dean/assessment/shs','Dean\Assessment\AssessmentController@indexshs');
//cashier student list
Route::get('/cashier/getstudentlist','Cashier\Ajax\CashierController@getstudentlist');
//cashier main
Route::get('/viewledger/{idno}','Cashier\ViewLedger@index');
Route::get('/mainpayment/{idno}','Cashier\MainPayment@index');
Route::post('/mainpayment','Cashier\MainPayment@processpayment');
Route::get('/viewreceipt/{reference_id}','Cashier\ViewLedger@viewreceipt');
Route::get('/reverserestore/{reference_id}/{action}','Cashier\MainPayment@reverserestore');
Route::get('/collectionreport/{trandate}','Cashier\CashierReport@collectionreport');
Route::get('/otherpayment/{idno}','Cashier\OtherPayment@otherpayment');
Route::post('/otherpayment','Cashier\OtherPayment@processpayment');
Route::get('/othernonstudent','Cashier\OtherPayment@nonstudent');
Route::post('/othernonstudent','Cashier\OtherPayment@processnonstudent');
Route::get('/setreceipt','Cashier\MainPayment@setreceipt');
Route::post('/setreceipt','Cashier\Mainpayment@setreceiptno');
Route::get('/searchor','Cashier\ViewLedger@searchor');
Route::get('/printcollection/{transaction_date}','Cashier\CashierReport@printcollection');
//cashier ajax
Route::get('/cashier/ajax/getsubsidiary','Cashier\Ajax\CashierController@getsubsidiary');
Route::get('/cashier/ajax/searchor','Cashier\Ajax\CashierController@searchor');
?>
