<div class="blog-post">
	<a href="/posts/{{$post->id}}">
		<h3 class="blog-post-title">{{$post->title}}</h3>
	</a>
	<div class="blog-post-info d-flex">
		<p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by
			<strong>{{$post->user->name}}</strong>
		</p>
		@auth
		<div class="likes-count engagement-count ml-auto mr-2">
			<form action="/posts/{{$post->id}}/like" method="post">
				@csrf
				<button type="submit" class="toggle-heart 	{{$post->likes()->where(['user_id'=> auth()->id()])->exists() ? 'liked' : ''}}">❤
					<span class="likes-count-number">{{$post->likes->count()}}</span>
				</button>
			</form>
		</div>
		@else
		<div class="likes-count engagement-count ml-auto mr-2">
				<span class="toggle-heart">❤
					<span class="likes-count-number">{{$post->likes->count()}}</span>
				</span>
		</div>
		@endauth
		@if($post->user->id===auth()->id())
		<div class="editPost mr-2">
				<form action="/posts/{{$post->id}}/edit" method="GET">
					@csrf
					<button type="submit" class="btn btn-primary btn-sm">Edit Post</button>
				</form>
			</div>
		<form action="/posts/{{$post->id}}" method="POST">
			@method('DELETE')
			@csrf
			<button type="submit" class="btn btn-sm btn-danger mr-4">Delete</button>
		</form>
		@endif
	</div>

	<p>{{$post->body}}</p>
	<hr>
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