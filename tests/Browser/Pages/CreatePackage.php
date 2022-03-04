<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreatePackage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        /* this method defines the location where Dusk should expect this page to be */
        return '/packages/create';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        /* this method lets you run additional assertions to verify you're on the right page */
        $browser->assertTitle('Create Package');
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        /* provides shortcuts for @susk-style selectors */
        return [
            '@title' => 'input[name=title]',
            '@instructions' => 'textarea[name=instructions]',
        ];
    }

    public function fillBasicFields(Browser $browser, $packageitle = 'Best Package')
    {
        $browser->type('@title', $packageitle)
            ->type('@instructions', 'do this stuff and then that stuff');
    }
}
