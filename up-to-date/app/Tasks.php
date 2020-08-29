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
        $this->save();
    }
    public function uncompleted()
    {
        $this->status=false;
        $this->save();
    }
    public function parentPlan()
    {
        //article->user
        return $this->belongsTo(Plan::class,'id');
    }
}
