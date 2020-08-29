
@extends('layouts.app')



@section('content')


<div id="wrapper" style="margin: 25px 25px 25px 25px">
	<div id="page" class="container-full" >
        <div class="row">
            <div class="col-md-2" style="background-color:white; padding:6px" id="content">
                <div class="title">                    
                        @if  ($plan->status == 0)
                            <h2 style="color:Red">{{$plan->title}}
                        @else 
                            <h2 style="color: Green">{{$plan->title}}
                            <i class="fa fa-check-circle" ></i>
                        @endif
                    </h2>
                    <br>
                    Status: 
                        @if  ($plan->status == 0)
                            Incomplete
                        @else 
                            Complete
                        @endif 
                    <br>
                    Start Date: {{Str::of($plan->created_at)->before(' ')}}
                    <br>
                    Due Date:   {{Str::of($plan->due_date)->before(' ')}}
                    <br><br>
                    <div class="row">
                        <div class="col-10">
                        <form method="POST" action='/home/plans/{{$plan->id}}/complete'>
                            @csrf
                            @method('PUT')
                            <div class="control">
                                <button class="btn btn-success"  type="submit">Mark Complete</button>
                            </div>
                        </form>
                        </div>
                        <div class="col-2">
                        <a href="/home/plans/{{$plan->id}}/edit" data-toggle="tooltip" title="Edit" data-placement="right">
                            <i class="fa fa-lg fa-pencil-square-o" style=" vertical-align: middle;"></i>                            
                        </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tasks
                        <a href="/home/plans/{{$plan->id}}/createtask" class="float-right"><i class="fa fa-plus-circle">Create Task</i></a>
                    </div>
                    <div class="card-body">
                    <div class="row big-text">
                        <div class="col-2">Title</div>
                        <div class="col-2">Start</div>
                        <div class="col-2">Due Date</div>
                        <div class="col-2">Assigned to</div>
                        <div class="col-2">Status</div>
                        <div class="col-1"></i></div>
                        <div class="col-1"></i></div>
                        
                    </div>
                    @forelse ($tasks as $task)
                            
                                <div class="row">
                                    
                                        @if  ($task->status == 0)
                                        
                                            <div class="col-2">{{$task->title}}</div>
                                            <div class="col-2">{{Str::of($task->created_at)->before(' ')}}</div>
                                            <div class="col-2">{{Str::of($task->due_date)->before(' ')}}</div>
                                            <div class="col-2">{{$task->user_assigned }}</div>
                                            <div class="col-2">Incomplete</div>

                                            <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/complete'>
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                                <div class="control">
                                                    <button class="btn"  type="submit"><div class="col-1"><i class="fa fa-check"></i></div></button>
                                                </div>
                                            </form>
                                            
                                            <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/delete'>
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                                <div class="control">
                                                    <button class="btn"  type="submit"><div class="col-1" ><i class="fa fa-trash"></i></div></button>
                                                </div>
                                            </form>
                                        @else 
                                        
                                            <div class="col-2" style="color: Green">{{$task->title}}</div>
                                            <div class="col-2" style="color: Green">{{Str::of($task->created_at)->before(' ')}}</div>
                                            <div class="col-2" style="color: Green">{{Str::of($task->due_date)->before(' ')}}</div>
                                            <div class="col-2" style="color: Green">{{$task->user_assigned }}</div>
                                            <div class="col-2" style="color: Green">Complete</div>

                                            <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/uncomplete'>
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                                <div class="control">
                                                    <button class="btn"  type="submit"><div class="col-1" style="color: Green"><i class="fa fa-check"></i></div></button>
                                                </div>
                                            </form>

                                            <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}/delete'>
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                                <div class="control">
                                                    <button class="btn"  type="submit"><div class="col-1" ><i class="fa fa-trash"></i></div></button>
                                                </div>
                                            </form>
                                            
  
                                            
                                        @endif
                                    
                                </div>                                                                  
                            
                        @empty 
                            <p>No tasks yet</p>
                        @endforelse
                       
                    </div>
                </div>
            </div>
            <div class="col-md-2"  style="background-color:white">
                <div class="row justify-content-center" style="padding:6px"> 
                    <h5>Collaborators</h5>
                    <a href="#" class="float-right"><i class="fa fa-plus-circle"></i></a>
                </div>
                No contibutors yet
            </div>
        </div>
	</div>
</div>

@endsection

