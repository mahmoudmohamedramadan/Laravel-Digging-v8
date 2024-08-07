<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /* You may use the `--class` option to specify the seeder class: >> `php artisan db:seed --class=UserSeeder` */

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /* Bypassing an array to `create` method we override the faker value which means that every time we seed the database the user name will be `override_faker_name` like the email */
        // \App\Models\User::factory(10)->create([
        //     'name' => 'override_faker_name', 'email' => 'override_faker_email'
        // ]);

        // Another way to create dummy 10 users
        // \App\Models\User::factory()->count(10);

        // Here we create 10 users that each user has one related post
        // \App\Models\User::factory()->count(10)->has(new \Database\Factories\PostFactory)->create();

        // Another way for the upper line
        // \App\Models\User::factory()->count(10)->hasPost(1)->create();

        /* The `call` method used to method to run a specific seeder class also, allowing you to control the seeding order */
        $this->call(UserSeeder::class);

        // You can also pass an array with seeders classes to the `call` method
        // $this->call([
        //     UserSeeder::class,
        //     PostSeeder::class,
        // ]);

        /* You may use the `query builder` to manually insert data or you may use `Eloquent model factories` */
        // \Illuminate\Support\Facades\DB::table('users')->insert([
        //     'name' => \Illuminate\Support\Str::random(10),
        //     'email' => \Illuminate\Support\Str::random(10) . '@gmail.com',
        //     'locale' => 'en',
        //     'password' => \Illuminate\Support\Facades\Hash::make('password'),
        // ]);
    }
}
