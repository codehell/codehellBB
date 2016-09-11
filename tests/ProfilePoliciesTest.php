<?php

use Codehell\Codehellbb\Policies\ProfilePolicies;
use Codehell\Codehellbb\tests\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfilePoliciesTest extends Helpers
{
    use DatabaseTransactions;

    public function test_profile_policies_guest()
    {
        $user = $this->createUser('Guest');
        $another_user = $this->createUser('User');
        $policies = new ProfilePolicies();
        $this->assertFalse($policies->index($user));
        $this->assertTrue($policies->edit($user, $user));
        $this->assertFalse($policies->edit($user, $another_user));
        $this->assertTrue($policies->update($user, $user));
        $this->assertFalse($policies->update($user, $another_user));
        $this->assertTrue($policies->updatePassword($user, $user));
        $this->assertFalse($policies->updatePassword($user, $another_user));
        $this->assertTrue($policies->updateEmail($user, $user));
        $this->assertFalse($policies->updateEmail($user, $another_user));
        $this->assertFalse($policies->updateRole($user));
    }

    public function test_profile_policies_user()
    {
        $user = $this->createUser('User');
        $another_user = $this->createUser('Guest');
        $policies = new ProfilePolicies();
        $this->assertFalse($policies->index($user));
        $this->assertTrue($policies->edit($user, $user));
        $this->assertFalse($policies->edit($user, $another_user));
        $this->assertTrue($policies->update($user, $user));
        $this->assertFalse($policies->update($user, $another_user));
        $this->assertTrue($policies->updatePassword($user, $user));
        $this->assertFalse($policies->updatePassword($user, $another_user));
        $this->assertTrue($policies->updateEmail($user, $user));
        $this->assertFalse($policies->updateEmail($user, $another_user));
        $this->assertFalse($policies->updateRole($user));
    }

    public function test_profile_policies_moderator()
    {
        $user = $this->createUser('Moderator');
        $another_user = $this->createUser('Guest');
        $policies = new ProfilePolicies();
        $this->assertTrue($policies->index($user));
        $this->assertTrue($policies->edit($user, $user));
        $this->assertFalse($policies->edit($user, $another_user));
        $this->assertTrue($policies->update($user, $user));
        $this->assertFalse($policies->update($user, $another_user));
        $this->assertTrue($policies->updatePassword($user, $user));
        $this->assertFalse($policies->updatePassword($user, $another_user));
        $this->assertTrue($policies->updateEmail($user, $user));
        $this->assertFalse($policies->updateEmail($user, $another_user));
        $this->assertFalse($policies->updateRole($user));
    }

    public function test_profile_policies_admin()
    {
        $user = $this->createUser('Admin');
        $another_user = $this->createUser('Admin');
        $policies = new ProfilePolicies();
        $this->assertTrue($policies->index($user));
        $this->assertTrue($policies->edit($user, $user));
        $this->assertTrue($policies->edit($user, $another_user));
        $this->assertTrue($policies->update($user, $user));
        $this->assertTrue($policies->update($user, $another_user));
        $this->assertTrue($policies->updatePassword($user, $user));
        $this->assertFalse($policies->updatePassword($user, $another_user));
        $this->assertTrue($policies->updateEmail($user, $user));
        $this->assertFalse($policies->updateEmail($user, $another_user));
        $this->assertTrue($policies->updateRole($user));
    }
}
