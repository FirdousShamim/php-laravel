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
        //dump(session('message'),$plan);
        return view('plans.addCollab',compact('plan'));
    }
    public function emailCollaborator(Plans $plan)
    {
        //dump(Str::of(request()->getPathInfo())->beforeLast('/'));

        request()->validate(['email'=>'required|email']);
        $a=(((object)($plan->load('author')->getRelations()))->author)->name;

        $url='http://up-to-date.test'.Str::of(request()->getPathInfo())->beforeLast('/');
        //dump(request('email'));
        //dump(User::all()->whereIn('email',request('email'))->first());

        Mail::to(request('email'))
             ->send(new AddCollab($url, $plan->title, $a ));

        $u=User::all()->whereIn('email',request('email'))->first();
        if ($u == NULL)
        {
            //user does'nt exist need to create a account
            //listen for the user registering
            //reflect the chnage in User and Collaborator DB
        }
        else
        {

            $collab= new Collaborators();
            $collab->user_id=$u->id;
            $collab->plan_id=$plan->id;
            $collab->save();
        }


        return redirect(route('plans.addCollab',$plan))
             ->with('message','Inivite for collaboration sent');

    }

    public function schedule()
    {
        $plans=Plans::all();
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
                $user->notify(new DueDateNear($user->name,'plan',$plan->title,$plan->due_date));
            }
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
