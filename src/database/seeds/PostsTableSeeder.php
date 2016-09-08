<?php
namespace Codehell\Codehellbb\database\seeds;

use Codehell\Codehellbb\Entities\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 100)->create();
    }
}
