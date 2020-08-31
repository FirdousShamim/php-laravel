<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

class Plans extends Model
{
    //
    
    protected $guarded = [];
    protected $casts = [
        'collaborator_id' => 'array',
    ];
    public function author()
    {
        //article->user[DO not touch,working fine ]
        return $this->belongsTo(User::class,'user_id'); //select * from user where planID=(current planID)
    }
    public function collaborators()
    {
           return $this->hasMany(Collaborators::class,'plan_id'); //select * from user where planID=(current planID)
        
    }
    public function isCompleted()
    {
        $plan=$this;
        $f=1;
        $plan->load('hasTasks');
        $r=$plan->getRelations();
        $r=(object)$r;
        $r=$r->hasTasks;
        // dump($r);
        foreach($r as $t)
        {
            if ($t->status == 1)
            {
               continue;
            }
            elseif ($t->status==0)
            {
                $f=0;
                break;
            }
        }
        // dd($f,$this);
        $this->status=$f;
        $this->save();
        //dump($this->status);

    }
    public function hasTasks()
    {
        //[DO not touch,working fine ]
        return $this->hasMany(Tasks::class,'plan_id');  //select * from tasks where plansId=current plans id)

    }
}
