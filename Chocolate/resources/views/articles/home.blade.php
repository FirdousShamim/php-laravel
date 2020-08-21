
@extends ('layout')

@section ('content')

<div id="wrapper">
	<div id="page" class="container">
		
			
				@foreach ($articles as $article)
					<div class="content">
						<h3><a href="articles/{{$article->id}}">{{$article->title}}</a></h3>
						<p>{{$article->excerpt}}</p>
					</div>
				@endforeach
			
	</div>	
</div>

@endsection