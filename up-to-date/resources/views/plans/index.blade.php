@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All your plans
                        <a href="/home/plans/create" class="float-right">New Plan</a>
                    </div>
                    <div class="card-body">
                        @forelse ($plans as $plan)
                            <div class="small-text">
                                <div class="row">
                                    <a href="#">{{$plan->title}}</a>
                                    <p class="float-right">{{$plan->status}}</p>
                                </div>                                
                            </div>
                        @empty 
                            <p>No plans yet</p>
                        @endforelse
                    </div>
                </div>
        </div>
    </div>

</div>
@endsection