<?php

namespace Codehell\Codehellbb\Entities;

use App\User as BaseUser;
use PDO;

class User extends BaseUser
{

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function getSkillAttribute()
    {
        return $this->profile->skill;
    }

    public function relatedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user')
            ->withTimestamps()
            ->withPivot('visited_at');
    }

    public function unreadCommentsCounter()
    {
        \DB::connection()->setFetchMode(PDO::FETCH_ASSOC);
        $data = \DB::select("
          SELECT posts.id, COUNT(comments.id) as nr_of_comments, forums.id as forum_id
          FROM posts 
          LEFT JOIN post_user on post_user.post_id = posts.id 
          INNER JOIN comments ON posts.id = comments.post_id 
          INNER JOIN forums ON forums.id = posts.forum_id
          WHERE post_user.post_id IS null 
          AND comments.created_at >= ?
          GROUP BY posts.id
          UNION
          SELECT posts.id , COUNT(comments.id) as nr_of_comments, forums.id as forum_id 
          FROM posts 
          INNER JOIN post_user on post_user.post_id = posts.id 
          INNER JOIN comments on posts.id = comments.post_id 
          INNER JOIN users on post_user.user_id = users.id 
          INNER JOIN forums ON forums.id = posts.forum_id
          WHERE post_user.user_id = ? AND comments.created_at > visited_at 
          GROUP BY posts.id
        
        ", [$this->created_at, $this->id]);

        return $data;
    }

    public function unvisitedPosts()
    {
        return Post::select()
            ->whereNotIn('id', $this->relatedPosts()->pluck('post_id'))
            ->where('created_at', '>=', $this->created_at);
    }
}
