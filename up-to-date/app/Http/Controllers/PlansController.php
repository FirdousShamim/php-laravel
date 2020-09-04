<?php

namespace App\Http\Controllers;

use App\Mail\AddCollab;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Plans;
use App\Tasks;
use Carbon\Carbon;
use App\User;
use App\Collaborators;
use App\Notifications\DueDateNear;
use Illuminate\Notifications\Notification;
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
        $a=(((object)($plan->load('author')->getRelations()))->author);
        if ( auth()->user() == $a   )
        {
        return view('plans.edit',compact('plan'));
        }
        else{
            return response()->json(['error' => 'Not the owner of the plan'], 403);
        }
    }
    public function update(Plans $plan)
    {
        //dump($plan);
        $a=(((object)($plan->load('author')->getRelations()))->author);
        if ( auth()->user() == $a   )
        {

            $plan->due_date=request('duedate');

            $plan->update($this->validatePlan());
            //dump($this,$this->validatePlan(), $plan);
            return redirect(route('plans.show',$plan));
        }
        else{
            return response()->json(['error' => 'Not the owner of the plan'], 403);
        }

    }

    public function addCollaborator(Plans $plan)
    {
        //dump(session('message'),$plan);
        $a=(((object)($plan->load('author')->getRelations()))->author);
        if ( auth()->user() == $a   )
        {

            return view('plans.addCollab',compact('plan'));
        }
        else{
            return response()->json(['error' => 'Not the owner of the plan'], 403);
        }
    }
    public function emailCollaborator(Plans $plan)
    {
        //dump(Str::of(request()->getPathInfo())->beforeLast('/'));

        request()->validate(['email'=>'required|email']);
        $a=(((object)($plan->load('author')->getRelations()))->author)->name;
        $cs=((object)($plan->load('collaborators')->getRelations()))->collaborators;

        $url='http://up-to-date.test'.Str::of(request()->getPathInfo())->beforeLast('/');
        //dump(request('email'));
        //dump(User::all()->whereIn('email',request('email'))->first());



        $u=User::all()->whereIn('email',request('email'))->first();
        $create=TRUE;

        if($u == NULL)
        {
            //user does'nt exist need to create a account
            //listen for the user registering
            //reflect the chnage in User and Collaborator DB
            $create=FALSE;
            return redirect(route('plans.addCollab',$plan))
             ->with('message','User does not exist');
        }
        else
        {
            $cs=Collaborators::all()->whereIn('user_id',$u->id);
            $matchThese = ['user_id' => $u->id , 'plan_id' => $plan->id];
            $results = Collaborators::where($matchThese)->get();
            //dump($results,$results->isEmpty());
            //dump($c->user_id, $u->id ,$c->plan_id,$plan->id);

            if($results->isEmpty())
            {

                $collab= new Collaborators();
                $collab->user_id=$u->id;
                $collab->plan_id=$plan->id;
                $collab->save();
                Mail::to(request('email'))
                ->send(new AddCollab($url, $plan->title, $a ));
                return redirect(route('plans.addCollab',$plan))
                ->with('message','Invitation sent Successfully');
            }
            else
            {
                    $create=False;
                    return redirect(route('plans.addCollab',$plan))
                    ->with('message','User is already a collaborator');


            }
            //

        }
  }

    public function schedule()
    {
        $plans=Plans::all();
        $tasks=Tasks::all();
        foreach ($plans as $plan)
        {
           // dump(date_diff(date('Y-m-d',(strtotime(now()))),date('Y-m-d',(strtotime($plan->due_date)))));
            //dump(now(), date('Y-m-d',(strtotime(now()))),date('Y-m-d',(strtotime($plan->due_date))));
            #dump(date_diff(date_create($plan->due_date),now()));
            $diff=date_diff(now(),date_create($plan->due_date));
            if ( (int)$diff->format("%r%a")  < 3 )
            {
                //dump('less than3 days remaining',now(),(int)$diff->format("%r%a"),$plan->due_date);
                $user=(((object)($plan->load('author')->getRelations()))->author);
                $url='http://up-to-date.test/home/plans/'.$plan->id;
                $user->notify(new DueDateNear($user->name,'plan',$plan->title,Str::of($plan->due_date)->before(' '),$url));
                $cs=((object)($plan->load('collaborators')->getRelations()))->collaborators;
                foreach($cs as $c)
                {
                    User::find($c->user_id)->notify(new DueDateNear($user->name,'plan',$plan->title,Str::of($plan->due_date)->before(' '),$url));
                }

            }
        }
        foreach ($tasks as $task)
        {
            $diff=date_diff(now(),date_create($task->due_date));
            if ( (int)$diff->format("%r%a")  < 3 )
            {   $plan=Plans::find($task->plan_id);
                $user=(((object)($plan->load('author')->getRelations()))->author);
                $url='http://up-to-date.test/home/plans/'.$plan->id;
                $user->notify(new DueDateNear($user->name,'task',$task->title,Str::of($plan->due_date)->before(' '),$url));
            }
        }
    }
    public function destroy(Plans $plan)
    {
        $cs=((object)($plan->load('collaborators')->getRelations()))->collaborators;
        $a=(((object)($plan->load('author')->getRelations()))->author);
        $t=((object)($plan->load('hasTasks')->getRelations()))->hasTasks;


        //dump(request(),$plan);
        if ( auth()->user() == $a   )
            {
                //dump("auth user");
                //dump($plan,$t,$cs);
                $plan->delete();
                //return redirect('plans.show',['plan'=>$plan ,'tasks'=>$t, 'collaborators'=>$cs]);
                return redirect()->route('plans.index', ['plan'=>$plan ,'tasks'=>$t, 'collaborators'=>$cs]);
            }
            else{
                return response()->json(['error' => 'Not the owner of the plan'], 403);
            }

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
