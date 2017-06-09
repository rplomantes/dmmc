<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    function User(){
        $this->belongsTo("User");
    }
}
