<?php

namespace Codehell\Codehellbb\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PDO;

class User extends Authenticatable
{

    use Notifiable;

    protected $table = 'cbb_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function adminsAndModerators()
    {
        return $this->where('skill','Admin')->orWhere('skill', 'Moderator')->get();
    }

    public function skill()
    {
        return $this->hasOne(Skill::class);
    }

    public function relatedPosts()
    {
        return $this->belongsToMany(Post::class, 'cbb_post_user')
            ->withTimestamps()
            ->withPivot('visited_at');
    }

    public function unreadCommentsCounter()
    {
        \DB::connection()->setFetchMode(PDO::FETCH_ASSOC);
        $data = \DB::select("
          SELECT cbb_posts.id, COUNT(cbb_comments.id) as nr_of_comments, cbb_forums.id as forum_id
          FROM cbb_posts 
          LEFT JOIN cbb_post_user on cbb_post_user.post_id = cbb_posts.id 
          INNER JOIN cbb_comments ON cbb_posts.id = cbb_comments.post_id 
          INNER JOIN cbb_forums ON cbb_forums.id = cbb_posts.forum_id
          WHERE cbb_post_user.post_id IS null 
          AND cbb_comments.created_at >= ?
          GROUP BY cbb_posts.id
          UNION
          SELECT cbb_posts.id , COUNT(cbb_comments.id) as nr_of_comments, cbb_forums.id as forum_id 
          FROM cbb_posts 
          INNER JOIN cbb_post_user on cbb_post_user.post_id = cbb_posts.id 
          INNER JOIN cbb_comments on cbb_posts.id = cbb_comments.post_id 
          INNER JOIN cbb_users on cbb_post_user.user_id = cbb_users.id 
          INNER JOIN cbb_forums ON cbb_forums.id = cbb_posts.forum_id
          WHERE cbb_post_user.user_id = ? AND cbb_comments.created_at > visited_at 
          GROUP BY cbb_posts.id
        
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
