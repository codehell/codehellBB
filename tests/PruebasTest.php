<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PruebasTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
        /*$user = $this->createUser('User', 'info@gami.com');
        echo $user->skill;
        $response = $this->call('PATCH', route('profiles.roles', $user));
        echo $response->getStatusCode();
        $this->assertEquals(200, $response->status());*/
    }
}
