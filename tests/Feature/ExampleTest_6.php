<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\UserSeeder;

class ExampleTest_6 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_database()
    {
        /* Imagine that you want to test that the `create user` page works correctly. What's the best way? Make an http call to the `store user` endpoint and then assert that user exists in database. it's easier and safer than inspecting the resulting `index users` page
        We have two primary assertions for the database; `$this->assertDatabaseHas` and `$this->assertDatabaseMissing`
        For both, pass the table name as first parameter, the data you're looking for as the second parameter, the specific database connection you want to test as the third */
        $this->post('users/store');

        $this->assertDatabaseHas('users', ['name' => 'Mahmoud Mohamed Ramadan']);
    }

    public function test_seeding()
    {
        /* If you use seeders in your application, you can run the equivalent of `php artisan db:seed` by running `$this->seed` in your test you can also pass a seeder class name to just seed that one class */

        /* seed all seeders */
        $this->seed();

        /* seed `UserSeeder` only */
        $this->seed(UserSeeder::class);
    }
}
