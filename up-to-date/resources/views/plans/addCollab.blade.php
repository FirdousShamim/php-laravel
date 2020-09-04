

@extends('layouts.app')

@section('plans')

<li>
    <a class="nav-link"  href="{{ url('/home/plans') }}">Plans</a>
</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Add Collaborator
            <a href="/home/plans/{{$plan->id}}" class="float-right"><i class="fa fa-arrow-left" >Back</i></a>

            </div>
            <div class="card-body">
                @if (session('message') == 'Invitation sent Successfully')
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @elseif (session('message') == 'User is already a collaborator')
                        <div class="alert alert-warning" role="alert">
                        {{ session('message') }}
                    </div>
                @elseif (session('message') == 'User does not exist')
                    <div class="alert alert-danger" role="alert">
                    {{ session('message') }}
                </div>
                @endif
                <form
                    method="POST"
                    action="/home/plans/{{$plan->id}}/addCollaborator" >
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">
                            Email Address
                        </label>
                        <div class="col-md-6">
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Invitation
                                </button>
                            </div>

                    </div>


            </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
