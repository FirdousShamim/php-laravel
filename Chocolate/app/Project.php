<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function user()
    {
        //project->user
        return $this->belongsTo(User::class); //select * from user where projectID=1(curent id of the project)
    }
}
