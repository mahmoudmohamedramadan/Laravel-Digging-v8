<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DuskTest_2 extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        /* dusk offers a few methods you can use to ensure your test handle timing issues correctly. some of these methods are useful for interacting with intentionally slow or delayed elements of the page */
        $this->browse(function (Browser $browser) {
            $browser->visit('/user/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'admin')
                ->pause(500)
                ->click('login')
                ->assertSee('Laravel');
            /* waits until the given element exists on the page */
            $browser->waitFor('selector', 'maxSeconds');
            /* waits until disappears from the page */
            $browser->waitUntilMissing('@selector', 5);
            /* similar to waitFor, but accepts a closure as the second parameter which will define what action to take when he specified element becomes available */
            $browser->whenAvailable('selector', function ($chat) {
                $chat->assertSee('How are you in my Laravel project?');
            });
            /* waits for text to show up on the page, or times out after the optional second parameter's second count */
            $browser->waitForText('text', 'maxSeconds');
            /* waits for link to exist with the given link text, or times out after the optional second parameter's second count */
            $browser->waitForLink('linkText', 'maxSeconds');
            /* waits until the page URL matches the provided path */
            $browser->waitForLocation('path');
            /* waits until the page URL matches the URL for provided route */
            $browser->waitForRoute('routeName', ['segment' => 'value']);
            /* waits until the page reloads */
            $browser->waitForReload();
            /* waits until the provided JavaScript expression evaluates as true */
            $browser->waitUntil('expression');
            /* there's a huge list of assertions you can make against your app wih Dusk for more info visit
            https://laravel.com/docs/8.x/dusk */
            $browser->assertTitleContains('text');
            $browser->assertQueryStringHas('keyName');
            $browser->assertHasCookie('cookieName');
            $browser->assertSourceHas('hmlSourceCode');
            $browser->assertChecked('selector');
            $browser->assertSelectHasOption('selectorForSelect', 'optionValue');
            $browser->assertVisible('selector');
            $browser->assertFocused('selector');
            $browser->assertVue('dataLocation', 'dataValue', 'selector');
        });
    }
}
