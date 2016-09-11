<?php

use Codehell\Codehellbb\tests\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends Helpers
{
    use DatabaseTransactions;

    public function testRegister()
    {
        $this->visit('/')
            ->click('Register')
            ->seePageIs(url('/register'))
            ->type($this->name, 'name')
            ->type($this->email, 'email')
            ->type($this->password, 'password')
            ->type($this->password, 'password_confirmation')
            ->press('Register')
            ->seePageIs($this->baseUrl . '/home')
            ->see($this->name);

        $this->seeCredentials([
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => $this->password
        ]);
    }

    function testLogin()
    {
        $user = $this->createUser('User');
        $this->visit('/')
            ->click('Login')
            ->type($user->email, 'email')
            ->type($this->password, 'password')
            ->press('Login');
        
        $this->seeIsAuthenticatedAs($user);

        $this->seePageIs('/home')
            ->see('You are logged in!')
            ->see($user->name);
    }
}
