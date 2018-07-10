@extends('layouts.master')
@section('content')
<div class="col-sm-8 blog-main">
	@foreach($posts as $post)
	<div class="single-article">
		<div class="single-article-wrapper">
			<div class="small-pic">
				<a href="#" class="small-pic-link-wrapper">
					<img src="https://i1.wp.com/laracasts.s3.amazonaws.com/images/generic-avatar.png"
					    alt="profile pic"> </a>
			</div>
			<div class="single-article-body">
				<a class="content-title" href="/posts/{{$post->id}}">
					<h3>{{$post->title}}</h3>
				</a>
				<h4>
					<a href="#">{{$post->user->name}}・{{$post->created_at->toFormattedDateString()}}</a>
				</h4>
				{{-- @dump($post->tags->all()) --}}
				@if($tags = $post->tags->pluck('name')->all())
				<div class="tags">
					@foreach($post->tags->pluck('name')->all() as $tag)
					<a href="/t/{{$tag}}">
					<span class="tag">#{{$tag}}</span>
					</a>
					@endforeach
				</div>
				@endif
			</div>
		</div>
		<div class="single-article-footer">
			<div class="likes-count engagement-count mx-4">
			<form action="/posts/{{$post->id}}/like" method="post">
					@csrf
			<button type="submit" class="toggle-heart 	{{$post->likes()->where(['user_id'=> auth()->id()])->exists() ? 'liked' : ''}}">❤ <span class="likes-count-number">{{$post->likes_count}}</span></button>
				</form>
			</div>
			<div class="comments-count engagement-count">

					<span class="comments"><svg xmlns="http://www.w3.org/2000/svg" class="comments_svg" viewBox="0 0 512 512"><path d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4 32.7 12.3 69 19.4 107.4 19.4 141.4 0 256-93.1 256-208S397.4 32 256 32z"/></svg> {{$post->comments_count}}</span>
			</div>
			<a href="/posts/{{$post->id}}" class="btn btn-secondary btn-sm ml-auto" role="button" aria-pressed="true">View Post</a>
		</div>
	</div>
	@endforeach


	<nav class="blog-pagination my-4 mx-auto" style="width: 200px;">
		<a class="btn btn-outline-primary" href="#">Older</a>
		<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
	</nav>

</div>
<!-- /.blog-main -->
@endsection