@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All your Tasks</div>
                    <div class="card-body">

                    @foreach ($tasks as $task)
                     <p>{{$task->title}}---{{$task->id}}---{{$task->plan_id}}</p>
                    @endforeach
                    </div>
                </div>
            </div>
    </div>

</div>
@endsection