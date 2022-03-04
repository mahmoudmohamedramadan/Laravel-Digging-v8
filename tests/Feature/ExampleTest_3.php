<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest_3 extends TestCase
{
    /* there are 40 assertions available on the `$response` object, Let's dig into them */

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_response_types()
    {
        $response = $this->get('/');

        /* `assertOk` assert that response's status code is 200 */
        $response->assertOk();

        /* `assertStatus` assert that response's code is equal to provided `$status` */
        $response->assertStatus(505);

        /* `assertSee`, `assertDontSee` assert that response contains the provided `$text` or NOT */
        $response->assertSee('welcome');
        $response->assertDontSee('hi');

        /* `assertJson` assert that passed array is represented in the returned JSON; as well as `assertJson`, there are also `assertJsonCount`, `assertJsonFragment`, `assertJsonMissing`, `assertJsonMissingExact`, `assertJsonStructure` and `assertJsonValidationErrors` */
        $response->assertJson([
            'status' => 200
        ]);

        /* `assertViewHas` assert that the view on the visited page had a piece of data available at `$key`, and optionally checks that the value of that variable was `$value` */
        $response->assertViewHas('user', 'Mahmoud Mohamed Ramadan');

        /* `assertSessionHas` assert that the session has data set at `$key`, and optionally checks that the value of that data was `$value` */
        $response->assertSessionHas('user', 'Mahmoud Mohamed Ramadan');

        /* `assertSessionHasErrors` assert that there's at least one error set in Laravel's special error session container,
        Its first parameter can be an array of `key/value` pairs that define the errors that should be set and its second parameter can be the string format that check errors should be formatted against also you can pass third parameter as an error bag, in addition to `assertSessionHasErrors` there are also `assertSessionHasNoErrors` and `assertSessionHasErrorsIn` assertions */
        $response->assertSessionHasErrors();

        /* Assuming the `/login` route requires an email and we're posting an empty submission to it trigger the error */
        $responsePost = $this->post('/login', []);
        $responsePost->assertSessionHasErrors([
            'email' => 'The email field is required',
            '<p>:message</p>'
        ]);

        /* `assertCookie` assert that the response contains a cookie with name `$name`, and optionally checks that itsn value is `$value` */
        $response->assertCookie('password', 'admin');

        /* `assertCookieExpired` assert that the response contains a cookie with name `$name`, and that it is expired */
        $response->assertCookieExpired('password');

        /* `assertCookieNotExpired` assert that the response contains a cookie with name `$name`, and that it is NOT expired */
        $response->assertCookieNotExpired('password');
        $this->post('/posts/store', [
            'user_id' => 1,
            'body' => 'welcome from test'
        ]);

        /* `assertRedirect` assert that requested route returns a redirect to the give URI */
        $response->assertRedirect('/posts/create');
    }
}
