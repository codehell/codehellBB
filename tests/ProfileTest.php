<?php

use Codehell\Codehellbb\tests\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends Helpers
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_edit_name_profile()
    {
        $user = $this->createUser('Admin');
        $this->actingAs($user)
            ->visit($this->baseUrl . '/forums')
            ->click('Profile')
            ->type('Another Name', 'name')
            ->press('update_name')
            ->seePageIs(route('profiles.edit', $user))
            ->seeInDatabase('users', [ 'name' => 'Another Name']);
    }

    public function test_edit_password_profile()
    {
        $user = $this->createUser('Admin');

        $this->actingAs($user)
            ->visit($this->baseUrl . '/forums')
            ->click('Profile')
            ->type('secret', 'old_password')
            ->type('laravel', 'password')
            ->type('laravel', 'password_confirmation')
            ->press('update_password')
            ->seePageIs(route('profiles.edit', $user))
            ->seeCredentials([
                'email' => $user->email,
                'password' => 'laravel',
            ]);
    }

    public function test_change_rol_profile()
    {
        $user = $this->createUser('Admin');

        $this->actingAs($user)
            ->visit($this->baseUrl . '/forums')
            ->click('Profile')
            ->select('2', 'skill')
            ->press('update_skill')
            ->dontSeeElement('update_skill');
    }

    public function test_edit_email_profile()
    {
        $user = $this->createUser('Admin');

        $this->actingAs($user)
            ->visit($this->baseUrl . '/forums')
            ->click('Profile')
            ->visit(route('profiles.edit', $user))
            ->type('admin@codehell.info', 'email')
            ->press('update_email')
            ->seeInDatabase('profiles', ['new_email' => 'admin@codehell.info']);
    }

    public function test_email_confirmation()
    {
        $token = str_random(60);
        $user = $this->createUser('Admin');
        $profile = $user->profile;
        $profile->registration_token = $token;
        $profile->save();
        $this->seeInDatabase('profiles', [
            'user_id' => $user->id,
            'registration_token' => $token,
        ]);
        $this->actingAs($user)->call('GET', route('confirmation', $profile->registration_token));
        $this->seeInDatabase('profiles', [
            'user_id' => $user->id,
            'registration_token' => null
        ]);
    }

    public function test_ban_user()
    {
        $admin = $this->createUser('Admin');
        $user = $this->createUser('User');
        $this->actingAs($admin)
            ->visit(route('profiles.edit', $user->id))->type('ban test', 'ban_reason')
            ->press('ban_user')
            ->see(trans('codehellbb::forum.alert.user_banned'));

        $this->seeInDatabase('profiles', [
            'user_id' => $user->id,
            'banned' => true,
            'ban_reason' => 'ban test'
        ]);
    }
}
