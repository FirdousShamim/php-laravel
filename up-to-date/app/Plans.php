<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    //
    protected $guarded = [];
    public function author()
    {
        //article->user
        return $this->belongsTo(User::class,'user_id');
    }
    public function completed()
    {
        $this->status=true;
        $this->save();
    }
    public function hasTasks()
    {
        return $this->hasMany(Tasks::class,'plan_id');
    }
}
