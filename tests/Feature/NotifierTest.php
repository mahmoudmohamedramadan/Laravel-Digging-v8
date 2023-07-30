<?php

namespace Tests\Feature;

use Mockery;
use App\Notifier;
use Tests\TestCase;
use App\SlackClient;

class NotifierTest extends TestCase
{
    /* When you are testing Laravel applications, you can wish to "mock" certain aspects of your application so they are not actually executed during a given test. For instance, when you are testing a controller that dispatches an event, you may want to mock the event listeners so they are not actually executed during the test. This will allow you to only test the controller's HTTP response without worrying about the execution of the event listeners, since the event listeners can also be tested in their own test case. for more info...https://www.w3resource.com/laravel/mocking.php */

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_notifier_admins()
    {
        /* We have a class named `Notifier` that we're testing, it has a dependency named `SlackClient` that does something that we do not want it to do when we're running our tests, it sends actual Slack notifications.So we're going to mock it

        We use Mockery to get a mock of our `SlackClient` class. Of we do not care about what happens to that class--if it should simply exist to keep our tests from throwing errors-- we can just use `shouldIgnoreMissing` */

        $slackMock = Mockery::mock(new SlackClient())->shouldIgnoreMissing();

        $notifier = new Notifier($slackMock);
        $notifier->notifyAdmins('Welcome from mockery');

        $this->assertTrue(true == true, 'condition is true');
    }

    public function test_notifier_notifies_admins()
    {
        /* `shouldReceive('send')->once()` is the same as saying assert that `$slackMock` will have its `send` method called once and only once` So we're now asserting that Notifier, when we call `notifiyAdmins`, makes a single call to the `send` method on SlackClient */
        $slackMock = Mockery::mock(new SlackClient());
        $slackMock->shouldReceive('send')->once();
        $slackMock->shouldReceive()->send()->andReturn(true);
        // $slackMock->shouldReceive()->times(3);
        // $slackMock->shouldReceive(')->never();

        $notifier = new Notifier($slackMock);
        $notifier->notifyAdmins('Test Message');

        // A convenient shortcut to creating and binding a Mockery instance to the container
        Mockery::mock(new SlackClient, function ($mock) {
            $mock->shouldReceive()->send();
        });
    }
}
