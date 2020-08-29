<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plans;
use App\User;
class PlansController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //dump(Plans::latest()->whereIn('user_id', [auth()->user()->id])->get());
        return view('plans.index',['plans'=>Plans::latest()->whereIn('user_id', [auth()->user()->id])->get()
        ]);
    }
    public function create()
    {
        return view('plans.create');
    }
    public function show(Plans $plan)
    {       

        $plan->load('hasTasks');
        $r=$plan->getRelations();
        $r=(object)$r;
        $r=$r->hasTasks;
        // $ap=Plans::all();
        // $l=$ap->last();
        //dump($p,$ap,$l,$l->hasTasks());
        //dump($plan,$r);

        return view('plans.show',['plan'=>$plan ,'tasks'=>$r
        ]);
    }
    public function store()
    {
        //die('Hello'); 
        //dump(request()->all());
        $this->validatePlan();
        
        $plan= new Plans();
        $plan->title=request('title');
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
        $plan->update($this->validatePlan());
        //dump($plan);
        return redirect(route('plans.show',$plan));
    }
    public function complete(Plans $plan)
    {        
        // $plan->completed();
        //dd($plan);
        return redirect(route('plans.show',$plan));
    }
    protected function validatePlan()
    {
        return request()->validate([
            'title'=>['required','min:3','max:255'],
            'due_date' => ['required|date_format:Y-m-d']
            
            ]);
         
    }
    
}
