<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public static function archives()
    {
        return static::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
        ->groupBy('year', 'month')
        ->orderByRaw('min(created_at) desc')
        ->get()
        ->toArray();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(\App\Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'liked');
    }


    public function like()
    {
        $attributes = ['user_id' => auth()->id()];
        if ($this->likes()->where($attributes)->exists()) {
            return"paiche";
        }
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
