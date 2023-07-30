<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\{Http\UploadedFile, Support\Facades\Storage};

class ExampleTest_11 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // You can specify the disk which you want to fake it
        Storage::fake();
        // Storage::fake('users');

        // Uploads a fake image
        $this->postJson('screenshots', [
            'screenshot' => UploadedFile::fake()->image('screenshot.jpg')
        ]);
    }

    public function test_mocks()
    {
        /* `Mocks` (and thier brethren, spies and stubs and dummies and fakes and number of other tools) are common in testing
        So what is mocking...
        Essentially, mocks and other similar tools make it possible o create an object that in some way mimics a real class, but for testing purpose is not the real class. Sometimes this is done because the real class is too dificult to instantiate just to inject it into a test, or maybe because the real class communicates with external services */
    }
}
