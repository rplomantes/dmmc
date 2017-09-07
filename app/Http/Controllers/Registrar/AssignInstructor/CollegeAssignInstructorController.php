<?php

namespace App\Http\Controllers\Registrar\AssignInstructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class CollegeAssignInstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index(){
        $instructors = User::where('accesslevel', 10)->get();
        return view('registrar.assigninstructor.college_index', compact('instructors'));
    }
    
    function viewprofile($id){
        $instructor = User::where('id', $id)->first();
        return view('registrar.assigninstructor.view_profile_college', compact('instructor'));
    }
    
    function loadsubjects($id){
        $user = \App\User::where('id', $id)->first();
        
        return view('registrar.assigninstructor.loadsubjects_college', compact('user'));
    }
    
    function viewmodify($id){
        $user = \App\User::where('id', $id)->first();
        
        return view('registrar.assigninstructor.viewmodify_college', compact('user'));
    }
    
    function modifyinfo(Request $request) {

        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required',
        ]);

        return $this->updateinfo($request);
    }
    
    function updateinfo(Request $request) {

        $id = $request->id;
        $idno = $request->idno;

        $user = User::where('idno', $idno)->first();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->extensionname = $request->extensionname;
        $user->email = $request->email;

        $user->save();

        return redirect("/registrar/assign_instructor/view_profile_college/$id");
    }
}
