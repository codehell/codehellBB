<?php

use Codehell\Codehellbb\Entities\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$comments = factory(\App\Entities\Comment::class, 50)->make();
        $comments->each( function($c) {
            \App\Entities\Comment::create($c->toArray());
        });*/
        factory(Comment::class, 50)->create();
        $comments = Comment::all();

        $comments->each( function($c) use($comments){
            $chosen = $comments->random();
            factory(Comment::class)->create([
                'parent' => $chosen->id,
                'post_id'=> $chosen->post_id,
            ]);
        });
    }
}
