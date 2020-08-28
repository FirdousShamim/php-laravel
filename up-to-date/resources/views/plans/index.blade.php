@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All your plans
                        <a href="/home/plans/create" class="float-right"><i class="fa fa-plus-circle">New Plan</i></a>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-10">Plans</div>
                            <div class="col-md-2">Status</div>
                        </div>
                         
                        @forelse ($plans as $plan)
                            <div class="small-text">
                                <div class="row">
                                    <div class="col-md-10"><a href="/home/plans/{{$plan->id}}">{{$plan->title}}</a></div>
                                    <div class="col-md-2">
                                        @if  ($plan->status == 0)
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
                    </div>
                </div>
            </div>
    </div>

</div>
@endsection