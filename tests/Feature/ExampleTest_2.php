<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\{WithFaker, RefreshDatabase, WithoutMiddleware, DatabaseTransactions};

class ExampleTest_2 extends TestCase
{
    use RefreshDatabase, DatabaseTransactions;

    /* `RefreshDatabase` takes two steps to ensure that your database tables are correctly migrated at the start of each test First, it runs your migrations on your test database once at the beginning of each test run and Second, it wraps each individual test method in a database transaction and rolles back the transaction at the end of the test, this means you have your database migrated for your tests and cleared out fresh after each test runs */

    /* `WithoutMiddleware` it'll disable all middleware for any test in that class, This measns that you won't have to worry about the authentication middleware or CSRF protection or anything else */

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // Disables the middleware for just this function
        $this->withoutMiddleware();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_it_calculate_area()
    {
        $length = 5;
        $width = 4;

        $this->assertEquals(10, $length * $width);
    }

    public function test_user_package()
    {
        /* Here we'll use make `instead` of create so the object is `created` and evaluated in memory without every hitting the database */
        $user = User::make(['name' => 'Mahmoud Ramadan', 'email' => 'admin@gmail.com']);
        $user2 = User::make(['name' => 'Mahmoud Ramadan', 'email' => 'admin@gmail.com']);

        // To check if the two parameters from same type/instance
        $this->assertInstanceOf($user, $user2);
        $this->assertTrue($user->exists(), $user2->exists());
    }

    public function test_http_laravel_requests()
    {
        $this->get('/', ['Content-Type' => 'text/html']);
        $this->post('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
        $this->put('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
        $this->patch('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
        $this->delete('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
    }

    public function test_post_request()
    {
        $response = $this->post(route('users.store'), [
            'name' => 'Mahmoud Mohamed Ramadan',
            'email' => 'admin@gmail.com',
            'password' => 'admin'
        ]);

        $response->assertOk();
    }

    public function test_json_api()
    {
        $this->getJson('/', ['Content-Type' => 'apllication/json']);
        $this->postJson('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
        $this->putJson('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
        $this->patchJson('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
        $this->deleteJson('', ['user' => 'Mahmoud Ramadan'], ['Content-Type' => 'text/html']);
    }
}
