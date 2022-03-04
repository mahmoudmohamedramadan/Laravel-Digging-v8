<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /* However, you may use the --class option to specify a specific seeder class to run individually >> `php artisan db:seed --class=UserSeeder` */

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /* Bypassing the array to `create` method we override the faker value which means that every time we seed the database the user name will be `override_faker_name` like the email also */
        // \App\Models\User::factory(10)->create(['name' => 'override_faker_name', 'email' => 'override_faker_email']);

        /* another way to create dummy 10 users */
        // \App\Models\User::factory()->count(10);

        /* here we create 10 users that each user has one related post */
        // \App\Models\User::factory()->count(10)->has(new \Database\Factories\PostFactory)->create();

        /* another way for the upper line */
        // \App\Models\User::factory()->count(10)->hasPost(1)->create();

        /* `call` method used to method to run a specific seeder class also, allowing you to control the seeding order */
        $this->call(UserSeeder::class);

        /* you can also pass an array WITH seeders classes to the `call` method */
        // $this->call([
        //     UserSeeder::class,
        //     PostSeeder::class,
        // ]);

        /* you may use the `query builder` to manually insert data or you may use `Eloquent model factories`. */
        // \Illuminate\Support\Facades\DB::table('users')->insert([
        //     'name' => \Illuminate\Support\Str::random(10),
        //     'email' => \Illuminate\Support\Str::random(10) . '@gmail.com',
        //     'locale' => 'en',
        //     'password' => \Illuminate\Support\Facades\Hash::make('password'),
        // ]);
    }
}
