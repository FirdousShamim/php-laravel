@extends ('layout')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
@endsection


@section ('content')
<div id='wrapper'>
        <div id='page' class="container">
            <h1 class="heading has-text-weight-bold is-size-4">Lets update Article</h1>
            <form method="POST" action='/articles/{{$article->id}}'>
            @csrf
            @method('PUT')
                <div class="feild">
                    <label class='label' for='title'>Title</label>

                    <div class="control">
                        <input class='input' type="text" name="title" id="title" value="{{$article->title}}">
                    </div>
                </div>

                <div class="feild">
                    <label class='label' for="excerpt">Excerpt</label>

                    <div class="control">
                        <input class='textarea' type="text" name="excerpt" id="excerpt" value="{{$article->excerpt}}">
                    </div>
                </div>

                <div class="feild">
                    <label class='label' for="body">Body</label>

                    <div class="control">
                        <input class='input' type="text" name="body" id="body" value="{{$article->body}}">
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