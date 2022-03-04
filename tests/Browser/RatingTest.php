<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class RatingTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        /* you can customize the environment variables for Dusk by creating a new file named .env.dusk.local (and you can replace .local if you're working in a different environment,like staging) */
        $this->browse(function (Browser $browser) {
            $browser->visit('/user/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', ' admin')
                ->press('Login')
                ->assertPathIs('/home');
        });

        /* $this->browse() creates a browser, which you pass into a closure; then, within he closure you instruct the browser which actions to take

        NOTE: you can also `ask` for more than one browser by adding parameters to the closure, which allows you to test how multiple users might interact with he website */
        $this->browse(function ($first, $second) {
            $first->loginAS(User::find(1))
                ->visit('home')
                ->waitForText('Welcome');

            $second->loginAS(User::find(2))
                ->visit('home')
                ->type('message', 'Hey, Second User');
        });
    }

    public function testInteractionExample()
    {
        /* If you've ever written jQuery, interacting with the page using Dusk will come naturally

            <div class="search">
                <button id="search-button"></button>
            </div>
            <button dusk="expand-nav"></button>
        */
        $this->browse(function ($browse) {
            $browse->click('.search-button');
            $browse->click('#search-button');
            $browse->click('@expand-nav');
        });
        /* As you see, adding the dusk attribute to your page elements allows you to reference them directly in a way that won't change when the display or layout of the page changes later; when any emthod asks for a selector, pass in the @ sign and then the content of your dusk attribute */
    }
}
