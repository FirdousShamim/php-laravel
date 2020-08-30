<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Tasks;
use App\Plans;
class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //We dont need to render tasks.index{ tasks are displaying in plans.show via realtionships(hasTasks)}

        //dump(request()->getPathInfo());
        // $path=request()->getPathInfo();
        // $plan_id=Str::of($path)->beforeLast('/')->afterLast('/');
        // return view('tasks.index',['tasks'=>Tasks::latest()->whereIn('plan_id', [$plan_id])->get(), 'plan_id'=>$plan_id
        // ]);
    }

    public function create(Plans $plan)
    {
        //dump($plan, request());
        if ( auth()->user() == ((object)($plan->load('author')->getRelations()))->author)
        {
            return view('tasks.createtask',['plan'=>$plan]);
        }
        else{
            return response()->json(['error' => 'Not Authorized to view this'], 403);
        }
    }

    public function store()
    {

        //dump(request());
        $this->validateTask();
        // //$task= new Tasks(request(['title','plan_id','duedate']));
        $task= new Tasks();
        $task->title=Str::ucfirst(request('title'));
        $task->due_date=request('duedate');
        $task->plan_id=request('plan_id');
        $task->save();
        //dump($task);
        return redirect(route('plans.show',$task->plan_id));
    }
    public function complete(Plans $plan)
    {        
        // 
        // dd('he');
        $task_id=Str::of(request()->getPathInfo())->beforeLast('/')->afterLast('/');
        $task=Tasks::all()->whereIn('id',$task_id)->first();
        $task->completed();
        //dump(request(),$task_id,$task);

        return redirect(route('plans.show',$plan));
    }
    public function uncomplete(Plans $plan)
    {        
        // 
        // dd('he');
        $task_id=Str::of(request()->getPathInfo())->beforeLast('/')->afterLast('/');
        $task=Tasks::all()->whereIn('id',$task_id)->first();
        $task->uncompleted();
        //dump(request(),$task_id,$task);

        return redirect(route('plans.show',$plan));
    }
    public function destroy(Plans $plan)
    {        
        // 
        // dd('he');
        $task_id=Str::of(request()->getPathInfo())->beforeLast('/')->afterLast('/');
        $task=Tasks::all()->whereIn('id',$task_id)->first();
        $task->delete();
        //dump(request(),$task_id,$task);

        return redirect(route('plans.show',$plan));
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
