<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CreatePackage;
use Tests\Browser\Components\RatingWidget;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DuskPackage extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(CreatePackage::class)
                ->type('@title', 'My Package Title');

            $browser->visit(CreatePackage::class)
                ->fillBasicFields('Greatset Package Ever')
                ->press('Create Package')
                ->assertSee('Greatest Package Ever');

            $browser->visit('/packages/mr/nove-stock-picker')
                ->within(new RatingWidget, function ($browser) {
                    $browser->ratePackage(2);
                    $browser->assertSeeIn('@average', 2);
                });
        });
    }
}
