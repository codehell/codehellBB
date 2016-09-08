<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Codehell\Codehellbb\Entities\User;
use Codehell\Codehellbb\Entities\Profile;
use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;

$factory->define(User::class, function (Faker\Generator $faker) {
    
    return [
        'name'      => $faker->userName,
        'email'     => $faker->safeEmail,
        'password'  => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Profile::class, function () {
    return [];
});
$factory->define(Forum::class, function (Faker\Generator $faker){
    $users = User::all();
    $name = $faker->text(64);
    $slug = str_slug($name, '-');
    return [
        'name' => $name,
        'description' => $faker->text(500),
        'slug' => $slug,
        'user_id' => $users->random()->id
    ];
});

$factory->define(Post::class, function (\Faker\Generator $faker) {
    $users = User::all();
    $forums = Forum::all();
    return [
        'title' => $faker->text(127),
        'content' => $faker->text(500),
        'user_id' => $users->random()->id,
        'forum_id' => $forums->random()->id,
        'disabled' => false,
    ];
});

$factory->define(\Codehell\Codehellbb\Entities\Comment::class, function(\Faker\Generator $faker) {
    $users = User::all();
    $posts = Post::all();
    return [
        'comment' => $faker->text(400),
        'user_id' => $users->random()->id,
        'post_id'=> $posts->random()->id,
    ];
});