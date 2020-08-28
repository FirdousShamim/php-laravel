<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //
    protected $guarded = [];
    public function parentPlan()
    {
        //article->user
        return $this->belongsTo(Plan::class,'id');
    }
}
