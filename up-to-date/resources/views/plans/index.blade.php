@extends('layouts.app')

@section('addplan')
    
    <a class="navbar-brand" href="{{ url('/') }}">
    Add Plan
                </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-4" style="border-style: solid;">
        list goes here 
        </div>
        <div class="col-sm-8">
            Detailed plan here
        </div>
    </div>

@endsection