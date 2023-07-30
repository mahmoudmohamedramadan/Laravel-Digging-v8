<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest_5 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_exception()
    {
        /* Maybe you're expecting a validation exception and you want to be caught as it would normally be by the framework, but if you want to temporarily disable the exception handler, that's an option; just run `$this->withoutExceptionHandling` and if for some reasons you need to turn it back on you can run `$this->withExceptionHandling` */
        $this->withoutExceptionHandling();
        $this->get('/');
        $this->assertTrue(true);
    }
}
