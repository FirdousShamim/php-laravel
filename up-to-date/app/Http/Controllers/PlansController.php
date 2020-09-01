<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Plans;

use App\User;
use Illuminate\Support\Facades\Mail;

class PlansController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //dump(Plans::latest()->whereIn('user_id', [auth()->user()->id])->get());
        //dump(((object)(((User::find([auth()->user()->id])->load('isCollaboratingIn'))->first())->getRelations()))->isCollaboratingIn);

        return view('plans.index',['plans'=>Plans::latest()->whereIn('user_id', [auth()->user()->id])->get(), 
                                    'collabs'=>((object)(((User::find([auth()->user()->id])->load('isCollaboratingIn'))->first())->getRelations()))->isCollaboratingIn 
         ]);
    }
    public function create()
    {
        return view('plans.create');
    }
    public function show(Plans $plan)
    {  
        $isCollaborator=False;
        $plan->isCompleted();
        $cs=((object)($plan->load('collaborators')->getRelations()))->collaborators;
        $a=(((object)($plan->load('author')->getRelations()))->author);
        $t=((object)($plan->load('hasTasks')->getRelations()))->hasTasks;
        foreach ($cs as $c)
        {
            //dump($c->user_id,auth()->user()->id);
            if($c->user_id == auth()->user()->id)
            {
                $isCollaborator=True;
                break;
            }
        }
            

        if ( auth()->user() == $a   )
        {
            //dump("auth user");
            //dump($plan,$t,$cs);
            return view('plans.show',['plan'=>$plan ,'tasks'=>$t, 'collaborators'=>$cs]);
        }
        elseif($isCollaborator == True)
        {
            return view('plans.show',['plan'=>$plan ,'tasks'=>$t, 'collaborators'=>$cs, 'owner'=>$a]);
        }
        else{
            return response()->json(['error' => 'Not Authorized to view this'], 403);
        }
    }
    public function store()
    {
        //die('Hello'); 
        //dump(request()->all());
        $this->validatePlan();
        
        $plan= new Plans();
        $plan->title=Str::title(request('title'));
        $plan->due_date=request('duedate');
        $plan->user_id=auth()->user()->id;
        $plan->save();

        return redirect(route('plans.index'));
    }
    public function edit(Plans $plan)
    {
        return view('plans.edit',compact('plan'));
    }
    public function update(Plans $plan)
    {
        //dump($plan);
        $plan->update($this->validatePlan());
        //dump($this,$this->validatePlan(), $plan);
        return redirect(route('plans.show',$plan));
    }

    public function addCollaborator(Plans $plan)
    {
        dump(session('message'),$plan);
        return view('plans.addCollab',compact('plan'));
    }
    public function emailCollaborator(Plans $plan)
    {
        request()->validate(['email'=>'required|email']);
        //dump(request('email'));
        Mail::raw('Invite',function($message){
            $message->to(request('email'))
                    ->subject('Collaborator');
        });
        return redirect(route('plans.addCollab',$plan))
             ->with('message','Inivite for collaboration sent');
    }
    // public function complete(Plans $plan)
    // {      
    //     $plan->isCompleted();
    //     //$plan->completed();
    //     //dd($plan);
    //     return redirect(route('plans.show',$plan));
    // }

    protected function validatePlan()
    {
        return request()->validate([
            'title'=>['required','min:3','max:255'],
            'due_date' => ['required|date_format:Y-m-d'],
            
            ]);
         
    }
    
}
