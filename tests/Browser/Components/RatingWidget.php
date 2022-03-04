<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class RatingWidget extends BaseComponent
{
    /* if you want the same functionality as Dusk pages offer, but without it begin constrained to specific URL, you'll likely want to reach for Dusk components >> php artisan dusk:compoentn componentName */

    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '.rating-widget';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@5-start' => '.five-star-rating',
            '@4-start' => '.four-star-rating',
            '@3-start' => '.three-star-rating',
            '@2-start' => '.two-star-rating',
            '@1-start' => '.one-star-rating',
            '@mine' => '.current-user-rating',
        ];
    }

    public function ratePackage(Browser $browser, $rating)
    {
        $browser->click(`@{rating}-star`)
            ->assertSeeIn('@mine', $rating);
    }
}
