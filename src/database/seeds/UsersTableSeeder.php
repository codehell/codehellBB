<?php
namespace Codehell\Codehellbb\database\seeds;

use Codehell\Codehellbb\Entities\User;
use Codehell\Codehellbb\Entities\Profile;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        factory(User::class)->create([
            'name'      => 'Damumo',
            'email'     => 'admin@codehell.info',
            'password'  => bcrypt('secret'),
        ]);

        $user = User::First();

        factory(Profile::class)->create([
            'user_id' => $user->id,
            'skill' => 'Admin'
        ]);

        factory(User::class, 10)->create()->each(function ($u) {
            factory(Profile::class)->create([
                'user_id' => $u->id,
                'skill' => 'Guest'
            ]);
        });
    }
}
