<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(\App\Post $post)
    {
        $isLikeExist = $post->likes()->where(['user_id'=> auth()->id()])->exists();
        if(!$isLikeExist){
            $post->likes()->create([
                'user_id' => auth()->id(),
                // 'liked_id' => $post->id,
                // 'liked_type' => get_class($post)
            ]);
        }else if($isLikeExist){
            $post->likes()->where('user_id', auth()->id())->delete();
        }
        return back();
    }


}
