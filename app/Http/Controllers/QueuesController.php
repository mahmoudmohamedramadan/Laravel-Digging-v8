<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\{Mail\GettingStarted, Jobs\UserReports};

class QueuesController extends Controller
{
    /* In a line at the bank. even if there are multiple lines-queues-only one person is being served at a time from each queue, and each person will eventually reach the front and be served. in some banks, it's strict FIFO sort of policy, but in other banks, there's not an exact guarantee that someone won't cut ahead of you in line at some point. Essentially, someone can get added to the queue, be removed from the queue prematurely, or be successfully `processed` and then removed. Queues in programming are very similar. your application adds a `job` to a queue, which is a chunk of code that tells the application how to perform a particular behavoir. Queues workers can delete the jobs, return them to the queue with a delay, or mark them as successfully processed. Laravel makes it easy to serve your queues using `Redis`, `beanstalkd`, `Amazon's Simple Queue Service (SQS)` */

    ### References
    // https://stackshare.io/stackups/beanstalkd-vs-rabbitmq
    // https://www.educba.com/rabbitmq-vs-redis/#:~:text=Redis%20is%20a%20database%20that,message%2Dbroker%20in%20most%20scenarios.&text=Message%20Durability%3A%20Messages%20are%20not%20lost%20once%20stored%20in%20RabbitMQ.

    ######## Why Queues
    /* Queues make it easy to remove a costly or slow process from any sychronous call. The most common example is sending mail--doing so can be slow, and you do not want your users to have to wait for mail to send in response to thier actions */

    ######## Basic Queue Configuration
    /* Queues have thier own dedicated config file (config/queue.php) that allows you to set up myltiple drivers and define which will be the default, `Laravel Forge` is a hosting management service provided by Taylor Otwell, that makes serving queues with Redis a breez. every server you create has a Redis configured automaically */

    /* Queued jobs can depending on the environment, take many shapes like arrays of data or simple strings. in laravel, hey will each be a collection of information containing the job name, the data payload, the number of attempts that have been made so far to process this job, and some other simple metadata. But you do not need to worry about any of that in your interactions with laravel, Laravel provides a structure called a Job, which intended to encapsulate a single task- a behavior that your application can be commanded to do and allow it to be added and pulled from a queue */

    public function index()
    {
        UserReports::dispatch(auth()->user());

        /* You can specify which named queue you're pushing a job onto, EX: you many differeniate your queues based on thier importance, naming one low and one high */
        UserReports::dispatch(auth()->user())->onQueue('high');

        /* You can also customize the amount of time your queue workers should wait before processing a job with the `delay()` method, which accepts either an integer representing the number of seconds to delay a job or a DateTime/Carbon instance */
        $delay = now()->addMinutes(5);
        UserReports::dispatch()->delay($delay);

        // NOTE: Amazon SQS does not allow delays longer than 15 minutes

        /* `php artisan queue:work` >> is a command to run all queue workers, every time there are jobs on the queue, it will pull down the first job, handle it, delete it, and move on to the next */

        ######## Error handling
        /* So, what happens when something goes wrong with your job when it's in the middle of processing...
        **Exceptions in handling** if an exception is thrown, the queue listener will release that job back onto the queue. The job will be rereleased to be processed again and again until it is able to finish successfully or until it has been attempted the maximum number of times allowed by your queue listener */

        ######## Limiting the number of tries
        /* The maximum number of tries is defined by the `--tries` switch passed to the queue:listen or queue:work Artisan command */

        /* If you do not set `--tries`, or if you set it to 0, the queue listener will allow infinite retries. That means if there are any circumstances in which a job can just never be completed. if at any point you'd like to check how many times a job has been attempted already use the `attempt()` method on the job itself */

        /* Once a job has exceeded its allowable number of retries, it's considered a failed job, before you do anything else, even if all you want to do is limit the number of times a job can be tried- you'll need to create the `failed jobs` database table. */
        // `php artisan queue:failed-table`, `php artisan migrate`

        /* Any job that has surpassed its maximum number of allowed attempts will be dumped there, but there are quite a few things you can do with your failed jobs. First, you can define a `failed` method on the job itself, which will run when that job fails */

        /* next, you can register a global handler for failed jobs, somewhere in the application's bootstrap- if you do not know where to put it, just put it in the `boot` method of `AppServiceProvider` */
    }

    public function davingQueues()
    {
        request()->storeContactFormDetails();
        Mail::to('mahmoud@laravel.com')->send(new GettingStarted(request()->user));

        return response()->json(['success' => 'true']);

        /* In the above code, when the `davingQueues` method is invoked it stores the contact form details in the database, sends an email to an address to inform them of a new contact form submission, and returns a JSON response. The issue with this code is that the user will have to wait until the email has been sent before they receive their response on the web browser. Although this might only be several seconds, it can potentially cause visitors to leave. To make use of the queue system, we could update the code to the following instead */

        request()->storeContactFormDetails();

        dispatch(function () {
            Mail::to('mahmoud@laravel.com')->send(new GettingStarted(request()->user));
        })->afterResponse();

        return response()->json(['success' => 'true']);

        /* The code above in the `storeContactFormDetails` method will now store the contact form details in the database, queue the mail for sending and then return the response. Once the response has been sent back to the user’s web browser, the email will be added to the queue so that it can be processed. By doing this, it means that we don’t need to wait for the email to be sent before we return the response */
    }
}
