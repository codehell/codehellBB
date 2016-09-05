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

$factory->define(Codehell\Codehellbb\Entities\User::class, function (Faker\Generator $faker) {
    
    return [
        'name'      => $faker->userName,
        'email'     => $faker->safeEmail,
        'skill'     => $faker->randomElement(['Admin', 'Moderator', 'User', 'Guest']),
        'password'  => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Codehell\Codehellbb\Entities\Forum::class, function (Faker\Generator $faker){
    $users = Codehell\Codehellbb\Entities\User::all();
    $name = $faker->text(64);
    $slug = str_slug($name, '-');
    return [
        'name' => $name,
        'description' => $faker->text(500),
        'slug' => $slug,
        'user_id' => $users->random()->id
    ];
});

$factory->define(\Codehell\Codehellbb\Entities\Post::class, function (\Faker\Generator $faker) {
    $users = Codehell\Codehellbb\Entities\User::all();
    $forums = Codehell\Codehellbb\Entities\Forum::all();
    return [
        'title' => $faker->text(127),
        'content' => $faker->text(500),
        'user_id' => $users->random()->id,
        'forum_id' => $forums->random()->id,
        'disabled' => false,
    ];
});

$factory->define(\Codehell\Codehellbb\Entities\Comment::class, function(\Faker\Generator $faker) {
    $users = Codehell\Codehellbb\Entities\User::all();
    $posts = Codehell\Codehellbb\Entities\Post::all();
    return [
        'comment' => $faker->text(400),
        'user_id' => $users->random()->id,
        'post_id'=> $posts->random()->id,
    ];
});