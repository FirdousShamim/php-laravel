
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
                        @if ($tasks ?? '')
                            @forelse ($tasks ?? '' as $task)
                                <div class="small-text">
                                    <div class="row">
                                        <div class="col-md-10"><a href="#">{{$task->title}}</a></div>
                                        <div class="col-md-2">
                                            @if  ($task->status == 0)
                                                Incomplete
                                            @else 
                                                Complete
                                            @endif
                                        </div>
                                    </div>                                                                  
                                </div>
                            @empty 
                                <p>No plans yet</p>
                            @endforelse
                        @else
                            <p>No tasks yet</p>
                        @endif
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

