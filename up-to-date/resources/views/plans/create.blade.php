@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
            <h1 class="heading has-text-weight-bold is-size-4">Lets Create a new Plan</h1>
            <form method="POST" action='/home/plans'>
            @csrf
                <div class="feild">
                    <label class='label' for='title'>Title</label>

                    <div class="control">
                        <input
                            class='input {{$errors->has('title')? 'is-danger' : ''}}'
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title')}}">
                        @if ($errors->has('title'))
                            <p class="help is-danger">{{$errors->first('title')}}</p>
                        @endif
                    </div>
                </div>
                <div class="feild " style="margin-bottom: 30px">
                    <label class='label' for='duedate'>Due Date</label>

                    <div class="control">
                        <input
                            class='input {{$errors->has('duedate')? 'is-danger' : ''}}'
                            type="date"
                            name="duedate"
                            id="duedate"
                            value="{{ old('duedate')}}">
                        @if ($errors->has('duedate'))
                            <p class="help is-danger">{{$errors->first('duedate')}}</p>
                        @endif
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="col-md-6 offset-md-5">
                        <button class="btn btn-primary " type="submit">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection
