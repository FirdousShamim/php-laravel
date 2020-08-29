<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    //
    protected $guarded = [];
    public function author()
    {
        //article->user[DO not touch,working fine ]
        return $this->belongsTo(User::class,'user_id'); //select * from user where planID=(current planID)
    }
    public function completed()
    {
        $this->status=true;
        $this->save();
    }
    public function hasTasks()
    {
        //[DO not touch,working fine ]
        return $this->hasMany(Tasks::class,'plan_id');  //select * from tasks where plansId=current plans id)

    }
}
