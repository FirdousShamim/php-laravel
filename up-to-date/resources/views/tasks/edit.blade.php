@extends ('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
@endsection


@section ('content')
<div id='wrapper'>
        <div id='page' class="container">
            <h1 class="heading has-text-weight-bold is-size-4">Lets update the Task</h1>
            <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}'>
            @csrf
            @method('PUT')          
                <div class="feild">
                    <input type="hidden" name="plan_id" value="{{$plan->id}}">

                    <label class='label' for='title'>Task Title</label>

                    <div class="control">
                        <input 
                            class='input {{$errors->has('title')? 'is-danger' : ''}}' 
                            type="text" 
                            name="title" 
                            id="title"
                            value="{{$task->title}}">
                        @if ($errors->has('title'))
                            <p class="help is-danger">{{$errors->first('title')}}</p>
                        @endif
                    </div>
                </div>
                <div class="feild ">
                    <label class='label' for='duedate'>Due Date</label>

                    <div class="control">
                        <input 
                            class='input {{$errors->has('duedate')? 'is-danger' : ''}}' 
                            type="date" 
                            name="duedate" 
                            id="duedate"
                            value="{{ $task->duedate}}">
                        @if ($errors->has('duedate'))
                            <p class="help is-danger">{{$errors->first('duedate')}}</p>
                        @endif
                    </div>
                    
                </div>     
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection