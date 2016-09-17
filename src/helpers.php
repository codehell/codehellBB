<?php

use Carbon\Carbon;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Skills;
use Codehell\Codehellbb\Entities\User;
use Codehell\Codehellbb\Entities\Profile;
use Illuminate\Database\Eloquent\Relations\Relation;

if (! function_exists('hell_email_sender')) {
    /**
     * Send a email to the user
     * @param User $user
     */
    function hell_email_sender(User $user)
    {
        $url = route('confirmation', ['token' => $user->profile->registration_token]);
        Mail::send('codehellbb::emails/registration', compact('user', 'url'), function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject(trans('codehellbb::forums.email.activation'));
        });
    }
}

if (! function_exists('hell_has_skill_or_more')) {

    /**
     * @param User $user
     * @param $skill
     * @return bool
     */
    function hell_has_skill_or_more(User $user, $skill)
    {
        $skills = [
            'Admin' => Skills::ADMIN,
            'Moderator' => Skills::MODERATOR,
            'User' => Skills::USER,
            'Guest' => Skills::GUEST
        ];

        return $skills[$user->profile->skill] >= $skills[$skill];
    }
}

if (! function_exists('hell_update_visit_time')) {
    /**
     * @param Post $post
     */
    function hell_update_visit_time(Post $post)
    {
        $user = auth()->user();

        if ($user->relatedPosts()->find($post->id) == null) {

            $user->relatedPosts()->attach($post, ['visited_at' => Carbon::now()]);
        } else {

            $user->relatedPosts()->updateExistingPivot($post->id, ['visited_at' => Carbon::now()]);
        }
    }
}

if (! function_exists('hell_get_relation_sql')) {
    /**
     * @param Relation $builder
     * @return array
     */
    function hell_get_relation_sql(Relation $builder)
    {
        $query = $builder->getBaseQuery()->toSql();
        $attr = $builder->getBindings();
        return [$query, $attr];
    }
}

if (! function_exists('hell_unread_comments_counter')) {
    /**
     * @param array $counter
     * @param Post $post
     * @param null $forum_id
     * @return array|int|mixed
     */
    function hell_unread_comments_counter(array $counter, $post, $forum_id = null)
    {
        if (! count($counter)) {
            return 0;
        }
        if (is_null($forum_id)) {
            $found = array_search($post->id, array_column($counter, 'id'));
            $nr_of_comments = $counter[$found]['nr_of_comments'];
        } else {

            $found = array_keys(array_column($counter, 'forum_id'), $forum_id);
            return $found;
        }
        if ($found === false) {
            return 0;
        }

        return $nr_of_comments;
    }
}

if (! function_exists('hell_is_new_post')) {

    function hell_is_new_post($builder, $post_id)
    {
        $found = $builder->has($post_id);

        return $found;
    }    
}

if (! function_exists('hell_has_new_post')) {

    function hell_has_new_post($builder, $forum_id)
    {
        $found = $builder->contains($forum_id);
        return $found;
    }
}

if (! function_exists('hell_act')) {

    function hell_act($counter, $new_posts, $forum_id)
    {
        return hell_unread_comments_counter($counter, null, $forum_id) ||
        hell_has_new_post($new_posts, $forum_id);
    }
}

if (! function_exists('hell_admins_and_moderators')) {

    function hell_admins_and_moderators()
    {
        return Profile::join('users', 'profiles.user_id', '=', 'users.id')
            ->where('skill', 'Admin')
            ->orWhere('skill', 'Moderator')->get();
    }
}
