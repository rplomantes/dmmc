<?php

namespace App\Http\Controllers\Registrar\AssignInstructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class TesdaAssignInstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index(){
        if(Auth::user()->accesslevel=="3"){
        $instructors = User::where('accesslevel', 10)->get();
        return view('registrar.assigninstructor.tesda_index', compact('instructors'));
        }
    }
    
    function viewprofile($id){
        if(Auth::user()->accesslevel=="3"){
        $instructor = User::where('id', $id)->first();
        return view('registrar.assigninstructor.view_profile_tesda', compact('instructor'));
        }
        }
    
    function loadsubjects($id){
        if(Auth::user()->accesslevel=="3"){
        $user = \App\User::where('id', $id)->first();
        
        return view('registrar.assigninstructor.loadsubjects_tesda', compact('user'));
        }
    }
    
    function viewmodify($id){
        if(Auth::user()->accesslevel=="3"){
        $user = \App\User::where('id', $id)->first();
        
        return view('registrar.assigninstructor.viewmodify_tesda', compact('user'));
        }
    }
    
    function modifyinfo(Request $request) {
        if(Auth::user()->accesslevel=="3"){

        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required',
        ]);

        return $this->updateinfo($request);
        }
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

        return redirect("/registrar/assign_instructor/view_profile_tesda/$id");
    }
}
