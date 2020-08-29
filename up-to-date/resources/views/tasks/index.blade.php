@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All your Tasks {{$plan_id}}

            
                        <a href="/home/plans/{{$plan_id}}/tasks/createtask" class="float-right"><i class="fa fa-plus-circle">Create Task</i></a>
                    </div>
                    <div class="card-body">

                    @foreach ($tasks as $task)
                    <div class="row">
                        <div  class="col">
                            {{$task->title}}
                        </div>
                        <div  class="col">
                            {{$task->id}}
                        </div>
                        <div  class="col">
                            {{$task->plan_id}}
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
    </div>

</div>
@endsection