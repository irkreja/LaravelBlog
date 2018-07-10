@extends('layouts.master')
@section('content')
<div class="col-sm-8 blog-main">
   <h1>Edit a Post</h1>
   <hr>
   <form method="POST" action="/posts/{{$post->id}}">
	   @csrf
	   @method('PUT')
	   <div class="form-group">
		   <label for="title">Title :</label>
	   <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}">
	   </div>
	   <div class="form-group">
		   <label for="body">Body :</label>
		   <textarea name="body" class="form-control" id="" cols="30" rows="10">{{$post->body}}</textarea>
	   </div>
	   <div class="form-group">
		   <label for="tags">Tags :</label>
		   <input type="text" class="form-control" id="tags" name="tags"  value="{{$post->tags->pluck('name')->implode(', ')}}">
	   </div>
	   <div class="form-group">
		   <button type="submit" class="btn btn-primary">Submit</button>
	   </div>
	   @include('layouts.errors')
   </form>

</div>
<!-- /.blog-main -->
@endsection