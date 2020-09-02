@extends ('layouts.app')

@section('plans')

<li>
    <a class="nav-link"  href="{{ url('/home/plans') }}">Plans</a>
</li>
@endsection

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <strong><h2>Lets update Plans</h2></strong>
                    </div>

            <form method="POST" action='/home/plans/{{$plan->id}}'>
            @csrf
            @method('PUT')
                <div class='form-group row'>
                    <label class="col-md-2 col-form-label text-md-right" for='title'>Title</label>

                    <div class="control col-md-8">
                        <input
                            class='form-control input {{$errors->has('title')? 'is-danger' : ''}}'
                            type="text"
                            name="title"
                            id="title"
                            value="{{$plan->title}}">
                        @if ($errors->has('title'))
                            <p class="help is-danger">{{$errors->first('title')}}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 30px">
                    <label class="col-md-2 col-form-label text-md-right" for='duedate'>Due Date</label>

                    <div class="control col-md-8">
                        <input
                            class='form-control input {{$errors->has('duedate')? 'is-danger' : ''}}'
                            type="date"
                            name="duedate"
                            id="duedate"
                            value="{{ $plan->duedate}}">
                        @if ($errors->has('duedate'))
                            <p class="help is-danger">{{$errors->first('duedate')}}</p>
                        @endif
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="col-md-6 offset-md-5">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        </div></div></div>
@endsection
