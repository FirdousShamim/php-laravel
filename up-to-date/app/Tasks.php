<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //
    protected $guarded = [];
    public function completed()
    {
        $this->status=true;
        $this->end_date=now();
        $this->save();
    }
    public function uncompleted()
    {
        $this->status=false;
        $this->end_date=NULL;
        $this->save();
    }
    public function parentPlan()
    {
        //article->user
        return $this->belongsTo(Plan::class,'plan_id');
    }
}
