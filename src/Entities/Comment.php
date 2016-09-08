<?php

namespace Codehell\Codehellbb\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany($this, 'parent');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return bool
     */
    public function hasReplies()
    {
        return $this->children()->count() ? true :false;
    }
}
