<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest_1 extends TestCase
{
    /* to run a specific test method in class run the next command >> `.\vendor\bin\phpunit tests\Feature\ExampleTest_1.php --filter test_it_names_things_well`, NOTE that you can ignore passing the method name and in this case will run a test on all of the class's methods */

    /* automatically, Laravel's testing system will run any files in the test directory whose names end with the word TEST */

    /* any time a Laravel application is running, it has a current `environment` name that represents the environment it's running in. This name may be set to `local`, `staging`, `production`, or anything else you want, You can retrieve this by running `app()->environment()` or `app()->environment('locale')`

    When you run test, Laravel automatically sets the environment to testing. This means you can test for if `app()->environment('testing')` to enable or disable */

    /* runs as `it names things well` */
    public function test_it_names_things_well()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /* runs as `It names things well` */
    public function testItNamesThingsWell()
    {
        $response = $this->get('/');

        $response->assertSuccessful();
    }

    /** @test */
    /* runs as `it names things well 2` */
    public function test_it_names_things_well_2()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /* this method will run also as if you prefix the method with `test` */
    public function it_names_things_well()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
