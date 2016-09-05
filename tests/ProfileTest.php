<?php

use Codehell\Codehellbb\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
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
            ->seeInDatabase('cbb_users', [ 'name' => 'Another Name']);
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
            ->seeInDatabase('cbb_users', ['new_email' => 'admin@codehell.info']);
    }

    public function test_email_confirmation()
    {
        $token = str_random(60);
        $user = factory(User::class)->create([
            'registration_token' => $token,
        ]);
        $this->seeInDatabase('cbb_users', [
            'id' => $user->id,
            'registration_token' => $user->registration_token
        ]);
        $this->actingAs($user)->call('GET', route('confirmation', $user->registration_token));
        $this->seeInDatabase('cbb_users', [
            'id' => $user->id,
            'registration_token' => null
        ]);
    }
}
