<?php
//Dean
Route::get('/dean/viewstudentstatus/{idno}','Dean\Main\ViewStudentStatus@index');
Route::post('/dean/main/selectsubjectcollege','Dean\Main\SelectSubject@college');
Route::post('/dean/main/selectsubjectshs','Dean\Main\SelectSubject@shs');
Route::post('/dean/main/registersubjects','Dean\Main\RegisterSubjects@index');
//Ajax Dean
Route::get('/ajax/getdeanstudentlist','Dean\Ajax\GetStudentListController@index');
Route::get('/dean/ajax/getofferingpersection','Dean\Ajax\GetOfferingPersection@index');
Route::get('/dean/ajax/addtogradecollege','Dean\Ajax\AddToGradeCollege@index');
Route::get('/dean/ajax/removesubject','Dean\Ajax\AddToGradeCollege@removesubject');
Route::get('/dean/ajax/addallsubjects','Dean\Ajax\GetOfferingPersection@addallsubjects');
Route::get('/dean/ajax/getofferingpersearch','Dean\Ajax\GetOfferingPersection@search');
Route::get('/dean/ajax/getofferingpersectionshs','Dean\Ajax\GetOfferingPersection@shs');
Route::get('/dean/ajax/addtogradeshs','Dean\Ajax\AddToGradeCollege@shs');
Route::get('/dean/ajax/removesubjectshs','Dean\Ajax\AddToGradeCollege@removesubjectshs');
Route::get('/dean/ajax/addallsubjectsshs','Dean\Ajax\GetOfferingPersection@addallsubjectsshs');

//studentlist
Route::get('/dean/studentlist','Dean\Main\StudentList@index');
Route::get('/dean/generatereport/studentlist/{course_offering_id}', 'Dean\Main\StudentList@printStudentlist');

//studentlist ajax
Route::get('/dean/ajax/studentlist/getsubjectlistcollege','Dean\Ajax\GetSubjectList@getlistcollege');
Route::get('/dean/ajax/studentlist/getsubjectlistpersearchcollege','Dean\Ajax\GetSubjectList@getlistpersearchcollege');
?>