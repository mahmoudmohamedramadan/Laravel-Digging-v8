<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ExampleTest_13 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_promote_console_command_promotes_user()
    {
        $user = User::factory()->create();

        // `mail:newuser` is a signatture in `WelcomeNewUser.php`
        $this->artisan('mail:newuser', ['userId' => $user->id]);

        // You can also make assertions against he response code you get from Artisan
        $code = $this->artisan('do:thing', ['--flagOfSomeSort' => true]);

        /* `0` means no errors were returned, NOTE that: you can also chain three new methods onto your `$this->artisan()` which calls: `expectsQuestion`, `expectsOutput` and `assertExitCode` */
        $this->assertEquals(0, $code);
    }

    public function test_make_post_console_command_performs_as_expected()
    {
        /* The first paramter of `expectsQuestion` is the question which we are execting to ask and the second parameter is the answer where `expectsOutput` just tests that the passed string is returned */
        $this->artisan('make:post', ['--expected' => true])
            ->expectsQuestion('what is the post title?', 'my best post now')
            ->expectsOutput('createing at my-best-now.md')
            ->expectsQuestion('what category?', 'construction')
            ->assertExitCode(0);
    }
}
