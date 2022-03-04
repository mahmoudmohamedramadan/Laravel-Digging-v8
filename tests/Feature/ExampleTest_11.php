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
        /* you can specify the disk which you want to fake it */
        Storage::fake();
        // Storage::fake('users');

        /* upload a fake image */
        $this->postJson('screenshots', [
            'screenshot' => UploadedFile::fake()->image('screenshot.jpg')
        ]);

        /* assert the file was stored */
        Storage::disk('users')->assertExists('newName.png');

        /* assert a file does NOT exist */
        Storage::disk('users')->assertMissing('newName.png');
    }

    public function test_mocks()
    {
        /* `Mocks` (and thier brethren, spies and stubs and dummies and fakes and number of other tools) are common in testing
        So what is mocking...
        Essentially, mocks and other similar tools make it possible o create an object that in some way mimics a real class, but for testing purpose is NOT the real class. Sometimes this is done because the real class is too dificult to instantiate just to inject it into a test, or maybe because the real class communicates with external services */
    }
}
