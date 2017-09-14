<?php

namespace App\Http\Controllers\Registrar\Sectioning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SetupSections extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function shsindex(){
        return ('This will be sectioning');
    }
}
