<?php

namespace Codehell\Codehellbb\Entities;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->posts()->with(['comments' => function ($query) {
            $query->orderBy('created_at', 'DESC');
        }]);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->posts()->count() ? false : true;
    }
}
