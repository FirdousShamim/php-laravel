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
                            <div class="col-md-10 col-sm-9">Plans</div>
                            <div class="col-md-2 col-sm-3">Status</div>
                        </div>

                        @foreach ($plans as $plan)
                            <div class="small-text">
                                <div class="row">
                                    <div class="col-md-10 col-sm-9"><a href="/home/plans/{{$plan->id}}">{{$plan->title}}</a></div>
                                    <div class="col-md-2 col-sm-3">
                                        @if  ($plan->status == 0)
                                            Incomplete
                                        @else
                                            Complete
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @foreach ($collabs as $collab)
                    <div class="row">
                        <div class="col-md-10 col-sm-9"><a href="/home/plans/{{$collab->plan_id}}">{{(App\Plans::find($collab->plan_id))->title}}</a></div>
                        <div class="col-md-2 col-sm-3">
                            @if  ((App\Plans::find($collab->plan_id))->status == 0)
                                Incomplete
                            @else
                                Complete
                            @endif
                        </div>
                    </div>

                    @endforeach


                    @if ( ($collabs->isEmpty()) &&  ($plans->isEmpty()))
                        No plans yet
                    @endif

                    </div>
                </div>
            </div>
    </div>

</div>
@endsection
