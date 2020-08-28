<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Tasks;
use App\Plans;
class TasksController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('tasks.index',['tasks'=>Tasks::latest()->get()
        ]);
    }
    public function create(Plans $plan)
    {
        //dump($plan);
        return view('tasks.createtask',['plan'=>$plan]);
    }
    public function store()
    {
        //die('Hello'); 
        //dump(request()->all() , Auth:: id(),Auth::user());
        $this->validateTask();
        //$task= new Tasks(request(['title','plan_id','duedate']));
        $task= new Tasks();
        $task->title=request('title');
        $task->due_date=request('duedate');
        $task->plan_id=request('plan_id');
        $task->save();
        //dump($task);
        return redirect(route('plans.show',$task->plan_id));
    }
    protected function validateTask()
    {
        return request()->validate([
            'title'=>['required','min:3','max:255'],
            'plan_id'=>['required'],
            'due_date' => ['required|date_format:Y-m-d']
            ]);
         
    }
}
