<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use \Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $posts = \App\Post::withCount(['likes','comments'])->with('tags', 'likes')->latest();

        if (count(request(['month','year'])) && Carbon::parse(request('month'))->month && Carbon::parse(request('year'))->year) {
            $posts = \App\Post::withCount(['likes','comments'])
                                ->with('tags', 'likes')
                                ->latest();

            if ($month = request('month')) {
                $posts->whereMonth('created_at', Carbon::parse($month)->month);
            }

            if ($year = request('year')) {
                $posts->whereYear('created_at', $year);
            }
        } else {
            $posts = \App\Post::withCount(['likes','comments'])->with('tags', 'likes')->latest();
        }



        $posts = $posts->get();



        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData=request()->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'tags'=> 'required|min:2'
        ]);


        $post=\App\Post::create([
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        $tags = collect(explode(',', request('tags')))->map(function ($tag) {
            return str_slug($tag, '');
        })->unique();

        $tags->each(function ($tag) use ($post) {
            if (!Tag::where(['name'=>$tag])->exists()) {
                Tag::create(['name' => $tag]);
            }
            $tag = Tag::where('name', $tag)->get();
            $post->tags()->attach($tag);
        });

        $request->session()->flash('message', 'Your Post Successfully Created!');

        return redirect()->home();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validatedData=request()->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'tags'=> 'required|min:2'
        ]);


        $post = tap($post)->update([
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);


        $tags = collect(explode(',', request('tags')))->map(function ($tag) {
            return str_slug($tag, '');
        })->unique();

        $post->tags()->detach();

        $tags->each(function ($tag) use ($post) {
            if (!Tag::where(['name'=>$tag])->exists()) {
                Tag::create(['name' => $tag]);
            }
            $tag = Tag::where('name', $tag)->get();
            $post->tags()->attach($tag);
        });

        $request->session()->flash('message', 'Your Post Successfully Updated!');

        return view('posts.show', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->user->id===auth()->id()) {
            if ($post->delete()) {
                $request->session()->flash('message', 'Your Post Successfully Deleted!');
                return redirect()->home();
            }
        } else{
            return redirect()->back();
        }
    }

    public function tags(\App\Tag $tag)
    {
        $posts = $tag->posts;
        return view('posts.index', compact('posts'));
    }

    public function archivesPosts()
    {
    }
}
