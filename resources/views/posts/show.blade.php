@extends('layouts.master')
@section('content')
<div class="col-sm-8 blog-main">
	@include('posts.post') {{-- Add a Comment --}}
	<div class="card">
		<ul class="list-group">
			@foreach($post->comments as $comment)
			<li class="list-group-item">
				<strong>{{ $comment->user->name}} ({{$comment->created_at->diffForHumans()}}):</strong>&nbsp; {{$comment->body}}
			</li>
			@endforeach
		</ul>
		@auth
		<div class="card-block">
			<form action="/posts/{{$post->id}}/comments" method="post">
				@csrf
				<div class="form-group">
					<textarea class="form-control" name="body" id="body" placeholder="Your Comment Here." rows="3"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary mb-2">Add Comment</button>
				</div>
			</form>
			@include('layouts/errors')
		</div>
		@endauth
	</div>
</div>
<!-- /.blog-main -->

@endsection