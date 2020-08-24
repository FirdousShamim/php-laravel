

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{ __('Email it') }}</div>
            <div class="card-body">
            <form
                method="POST"
                action="/contact"
                class="bg-white p-6 rounded  shadow-md"
                style="width:300px;"
                >
                @csrf

                <div class="col-8 mb-5">
                    <label 
                        for="email"
                        class="block text-xs uppercase font-semibold mb-1"
                        >
                        Email Address
                    </label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        class="border px-2 py-1 text-sm w-full"
                    >
                    @error('email')
                        <div class="text-red-500 text-xs">{{$message}} </div>
                    @enderror


                    
                </div>
                <button 
                        type="submit"
                        class="btn btn-primary">
                        Email ME
                </button>
                

                @if (session('message'))
                    <div>{{session('message')}}</div>
                @endif
            </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
