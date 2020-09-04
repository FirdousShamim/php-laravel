@extends ('layouts.app')



@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
            <h1 class="heading has-text-weight-bold is-size-4">Lets update the Task</h1>
            <form method="POST" action='/home/plans/{{$plan->id}}/tasks/{{$task->id}}'>
            @csrf
            @method('PUT')
                <div class="form-group row">
                    <input type="hidden" name="plan_id" value="{{$plan->id}}">

                    <label class='col-md-2 col-form-label text-md-right'  for='title'>Task Title</label>

                    <div class="control col-md-8">
                        <input
                            class='form-control input {{$errors->has('title')? 'is-danger' : ''}}'
                            type="text"
                            name="title"
                            id="title"
                            value="{{$task->title}}">
                        @if ($errors->has('title'))
                            <p class="help is-danger">{{$errors->first('title')}}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row"style="margin-bottom: 30px">
                    <label class='col-md-2 col-form-label text-md-right'  for='due_date'>Due Date</label>

                    <div class="control col-md-8">
                            <input
                                class='form-control  input {{$errors->has('due_date')? 'is-danger' : ''}}'
                                type="date"
                                name="due_date"
                                id="due_date"
                                value="{{ old('due_date')}}">
                            @if ($errors->has('due_date'))
                                <p class="help is-danger">{{$errors->first('due_date')}}</p>
                            @endif
                        </div>

                </div>
                <div class="field is-grouped">
                        <div class="col-md-6 offset-md-5">
                           <button class="btn btn-primary " type="submit">Update</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>


@endsection
