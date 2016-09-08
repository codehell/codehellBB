<?php
namespace Codehell\Codehellbb\database\seeds;

use Codehell\Codehellbb\Entities\Forum;
use Illuminate\Database\Seeder;

class ForumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Forum::class, 10)->create();
    }
}
