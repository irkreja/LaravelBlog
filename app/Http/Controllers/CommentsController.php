<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(\App\Post $post)
    {
        request()->validate([
            'body' => 'required'
        ]);

        \App\Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'body' => request('body')
        ]);

        return back();
    }
}
