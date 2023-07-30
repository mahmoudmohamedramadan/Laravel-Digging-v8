<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ExampleTest_12 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_users_route_should_be_cahced()
    {
        /* Imagine we have a controller method that uses a facade that's not one of the fakable systems we've already covered; we want to test that controller method and assert that a certian facade call was made
        ++++ Take a look at `index` method in `UserController.php` */

        $user = User::factory()->create();

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn(collect([$user]));

        $this->get('users')->assertJsonFragment(['name' => $user->name]);

        /* You can also use your facades as spies, which means you can set your assertions at the end and use `shouldHaveReceived` instead of `shouldReceive` */
    }

    public function test_user_should_be_cached_after_visit()
    {
        Cache::spy();

        $user = User::factory()->create();

        $this->get(route('users.show'), [$user->id]);

        Cache::shouldHaveReceived('put')
            ->once()
            ->with('user' . $user->id, $user->toArray());
    }
}
