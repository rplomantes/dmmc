<?php
//Dean
Route::get('/dean/viewstudentstatus/{idno}','Dean\Main\ViewStudentStatus@index');
Route::post('/dean/main/selectsubjectcollege','Dean\Main\SelectSubject@college');
Route::post('/dean/main/selectsubjectshs','Dean\Main\SelectSubject@shs');
//Ajax Dean
Route::get('/ajax/getdeanstudentlist','Dean\Ajax\GetStudentListController@index');
Route::get('/dean/ajax/getofferingpersection','Dean\Ajax\GetOfferingPersection@index');
Route::get('/dean/ajax/addtogradecollege','Dean\Ajax\AddToGradeCollege@index');
Route::get('/dean/ajax/removesubject','Dean\Ajax\AddToGradeCollege@removesubject');
Route::get('/dean/ajax/addallsubjects','Dean\Ajax\GetOfferingPersection@addallsubjects');
?>