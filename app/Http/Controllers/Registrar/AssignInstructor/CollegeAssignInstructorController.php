<?php

namespace App\Http\Controllers\Registrar\AssignInstructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class CollegeAssignInstructorController extends Controller
{
    function index(){
        $instructors = User::where('accesslevel', 10)->get();
        return view('registrar.assigninstructor.index', compact('instructors'));
    }
    
    function viewprofile($id){
        $instructor = User::where('id', $id)->first();
        return view('registrar.assigninstructor.view_profile', compact('instructor'));
    }
}
