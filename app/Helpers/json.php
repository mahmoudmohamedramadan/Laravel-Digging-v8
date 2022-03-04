<?php

namespace App\Helpers;

/* As you can see in the next example, the function itself is really simple. However, one thing that you might notice is that the function name is written in snake case (e.g.json_response) rather than camel case (e.g. jsonResponse) like you'd usually see with method names on a class. You aren't necessarily fixed to using camel case for defining the function name, but you'll find that all of the Laravel helper functions are written this way. So, I'd probably advise using the format just so that you can follow the typical standard and format that's expected. This is totally up to you though */

/* Another thing that you might have noticed is that we have wrapped the function name inside an `if` statement. This is to stop us from accidentally redeclaring any helpers with the same name that have already been registered. For example, let's say that we were using a package that already had a `json_response` function registered, this would prevent us from registering our own function with the same name. To get around this, we could just simply change the name of our own function to avoid any clashes */

/* It's also really important to remember when creating helper functions that they are only supposed to be used as helpers. They aren't really meant to be used to perform any business logic, but rather to help you tidy up your code. Of course, you can add complex logic to them, but if this is something you're looking to do, I'd probably advise thinking about if the
32 code would be a better fit in another place such as a service class, action class, or trait */

/* Now that we've created our helper file, we need to register it so that we can use our new function. To do this, we can update our `composer.json` file so that our file is loaded at runtime on each request and is available for using.
This is possible because Laravel includes the Composer class loader in the `public/index.php` file. In your `composer.json`
file, you should have a section that looks like this:"autoload": { "psr-4": { "App\\": "app/", "Database\\Factories\\": "database/factories/", "Database\\Seeders\\": "database/seeders/" }, "files": [ "app/Helpers/json.php" ] }, */

if (!function_exists('json_response')) {
    /**
     * Return a json response
     *
     * @param boolean $success
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    function json_response($success, $message)
    {
        return response()->json([
            'success' => $success,
            'msg' => $message,
        ]);
    }
}
