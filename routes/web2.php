<?php
//Dean
Route::get('/dean/viewstudentstatus/{idno}','Dean\Main\ViewStudentStatus@index');
//Ajax Dean
Route::get('/ajax/getdeanstudentlist','Dean\Ajax\GetStudentListController@index');
?>