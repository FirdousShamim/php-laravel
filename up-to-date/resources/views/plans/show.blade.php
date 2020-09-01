
@extends('layouts.app')



@section('content')


<div id="wrapper" style="margin: 25px 25px 25px 25px">
	<div id="page" class="container-full" >
        <div class="row">
            <div class="col-md-2" style="background-color:white; padding:6px;" id="content">
            
                @if  ($plan->status == 0)
                    <h3 style="color:Red">{{$plan->title}}</h3>
                @else 
                    <h3 style="color: Green">{{$plan->title}}
                    <i class="fa fa-check-circle" ></i></h3>
                @endif 
                <hr/>
                <ul>
                    @if  ($owner ?? '')
                        <li>Owner: {{$owner->name}}</li>
                    @endif
                    <li>
                        Status: 
                        @if  ($plan->status == 0)
                            Incomplete
                        @else 
                            Complete
                        @endif 
                    </li>
                    <li>
                        Start Date: {{Str::of($plan->created_at)->before(' ')}}
                    </li>
                    @if( $plan->end_date != NULL)
                        <li> End Date: {{Str::of($plan->due_date)->before(' ')}} </li>
                    @else
                    <li>
                        Due Date:   {{Str::of($plan->due_date)->before(' ')}}
                        <a href="/home/plans/{{$plan->id}}/edit"  data-toggle="tooltip" title="Edit" data-placement="right">
                        <i class="fa fa-pencil-square-o" style=" vertical-align: middle;"></i>                            
                        </a>
                    </li>
                    @endif
                </ul>
                <hr>                  
                <div class="row"> 
                    <div class="col-10"><h4>Collaborators</h4></div>
                    <div class="col-2"><a href="/home/plans/{{$plan->id}}/addCollaborator"><i class="fa fa-plus-circle"></i></a></div>                    
                </div>
                <ul>
                    @forelse($collaborators as $collaborator)
                        <li>{{(App\User::find($collaborator->user_id))->name}}</li>
                    @empty
                        No Collaborators yet
                    @endforelse
                       
                </ul>
                <hr>
                <a href="/home/plans" class="float-right">Go to Plans</a>
                
            </div>



            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Tasks
                        <a href="/home/plans/{{$plan->id}}/createtask" class="float-right"><i class="fa fa-plus-circle">Create Task</i></a>
                    </div>
                    <div class="card-body">              
                        <div class="card-columns">
                            
                            @forelse ($tasks as $task)
                                    @if  ($task->status == 0)
                                        <div class="card " >
                                            <div class="card-header">
                                                <a  class="collapsed d-block" data-toggle="collapse" href="#card-{{$task->id}}" aria-expanded="true" aria-controls="card-{{$task->id}}" id="heading-{{$task->id}}">
                                                    <i class="fa fa-chevron-down pull-right"></i>
                                                    {{$task->title}}
                                                </a>
                                            </div>
                                            <div id="card-{{$task->id}}" class="collapse" aria-labelledby="heading-{{$task->id}}">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Begin: {{Str::of($task->created_at)->before(' ')}}</li>
                                                <li class="list-group-item">Due: {{Str::of($task->due_date)->before(' ')}}</li>
                                                @if ($task->end_date != NULL )
                                                    <li class="list-group-item">End: {{Str::of($task->end_date)->before(' ')}}</li>
                                                @endif
                                               

                                            </ul>
                                            
                                            <div class="card-footer">
                                                <div class="row justify-content-end" >
                                                    <div class="col-1">
                                                        <a href="/home/plans/{{$plan->id}}/tasks/{{$task->id}}/edit"  data-toggle="tooltip" title="Edit" data-placement="right">
                                                            <i class="fa fa-pencil-square-o" style=" vertical-align: middle;"></i>                            
                                                        </a>
                                                    </div>
                                                    <div class="col-2">
                                                        <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/delete'>
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="task_id" value="{{$task->id}}">
                                                            <div class="control">
                                                                <button class="btn btn-sm"  type="submit"><div class="col-1" ><i class="fa fa-trash"></i></div></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-2">
                                                        <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/complete'>
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="task_id" value="{{$task->id}}">
                                                            <div class="control">
                                                                <button class="btn btn-sm"  type="submit"><i class="fa fa-check"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    @else
                                         <div class="card  border-success">
                                            <div class="card-header" style="color:Green">
                                                <a style="color:Green" class="collapsed d-block" data-toggle="collapse" href="#card-{{$task->id}}" aria-expanded="true" aria-controls="card-{{$task->id}}" id="heading-{{$task->id}}">
                                                    <i class="fa fa-chevron-down pull-right"></i>
                                                    {{$task->title}}    <i class="fa fa-check-circle" ></i> 
                                                </a>                                                      
                                            </div>
                                            <div id="card-{{$task->id}}" class="collapse" aria-labelledby="heading-{{$task->id}}">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Begin: {{Str::of($task->created_at)->before(' ')}}</li>
                                                @if ($task->end_date != NULL )
                                                    <li class="list-group-item">End: {{Str::of($task->end_date)->before(' ')}}</li>
                                                @endif
                                               
                                                
                                            </ul>
                                            
                                            <div class="card-footer">
                                                <div class="row justify-content-end" >
                                                    
                                                    <div class="col-2">
                                                        <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/delete'>
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="task_id" value="{{$task->id}}">
                                                            <div class="control">
                                                                <button class="btn btn-sm"  type="submit"><div class="col-1" ><i class="fa fa-trash"></i></div></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-2">
                                                        <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/uncomplete'>
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="task_id" value="{{$task->id}}">
                                                            <div class="control">
                                                                <button class="btn btn-sm"  type="submit"><i class="fa fa-check"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        
                                    @endif
                                    
                                                                                                   
                                
                            @empty 
                                <p>No tasks yet</p>
                            @endforelse
                        </div>
                        
                        
                    </div>

                    
                </div>
            </div>
            
        </div>
	</div>
</div>

@endsection