<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DuskTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testDuskMethods()
    {
        $this->browse(function (Browser $browse) {
            /* reurns the value of any text inpu if only one parameter is passed; sets the value of an input if a second param is passed */
            $browse->value('selector', 'value');
            /* gets the text content of a nonfillable item like a <div> or <span> */
            $browse->text('selector');
            /* returns the value of a particular attribute on he elemen matching selector */
            $browse->attribute('selector', 'attributeName');
            /* similar to value(), but actually types the characters rather than directly setting the value */
            $browse->type('selector', 'valueToType');

            /* With methods like type() that target inputs, Dusk will start by tring to match a Dusk or CSS selector will look for an input with th provided name and fnally will try to find a <textarea> with the provided name */

            /* select the option with the value of optionValue in a drop-down selectable by selector */
            $browse->select('selector', 'optionValue');
            /* check or uncheks a checkbox selectable by a selector */
            $browse->check('selector');
            $browse->uncheck('selector');
            /* select the option with the value of optionValue in a radio group selectable by selector */
            $browse->radio('selector', 'optionValue');
            /* attaches a file at filePath to the file input selectable by selector */
            $browse->attach('selector', 'filePath');
            /* follows a text link to its target */
            $browse->clickLink('selector');
            /* drags an item to another item */
            $browse->drag('selectorToDrag', 'selectorToDragTo');
            /* given first parameter of a selector and a second paramter of a number of pixels */
            $browse->dragLeft('selectorToDrag', 'selectorToDragTo');
            $browse->dragRight('selectorToDrag', 'selectorToDragTo');
            $browse->dragUp('selectorToDrag', 'selectorToDragTo');
            $browse->dragDown('selectorToDrag', 'selectorToDragTo');
            /* sends keypress events withn the context of a selector accroding to the instructions in instructions, you can even combine modifiers with your typing */
            $browse->keys('selector', 'instructions');
            /* this would type `this is GREAT`. as you cansee, adding an array to the list of items to type allows you to combine modifiers [wrapped with {}] with typing */
            $browse->keys('selector', 'this is ', ['{shift}', 'great']);
            /* if you'd like to just send your key sequence to the page, you can target the top level of your app or page as your sector like Vue and the top level is a <div> with an ID of app */
            $browse->keys('#app', ['{command}', '/']);
        });
    }
}
