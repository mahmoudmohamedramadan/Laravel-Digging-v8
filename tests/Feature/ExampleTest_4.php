<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ExampleTest_4 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_can_view_home()
    {
        /* It's common to use the testing with authentication and authorization. Most of the time your needs will be met with the `actionAs` chainable method, which takes a user */
        $guest = User::factory(1)->state('guest')->create();
        $response = $guest->actionAs($guest)->get('home');
        $response->assertStatus(401); // Unauthorized
    }

    public function test_member_can_view_home()
    {
        $member = User::factory(1)->state('member')->create();
        $response = $member->actionAs($member)->get('home');
        $response->assertOK();
    }
}
