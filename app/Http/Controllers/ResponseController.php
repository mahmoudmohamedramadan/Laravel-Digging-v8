<?php

namespace App\Http\Controllers;

use App\{
    Models\User,
    Http\Responses\CustomJSON,
};

class ResponseController extends Controller
{
    public function responseBasic()
    {
        // return response()->make('success');

        // return response()->json(['success' => true]);

        /* `jsonp` take a callback as a header and data is the body of this header */
        // return response()->jsonp('save message', ['success' => true]);

        /* `download` used to download file */
        // return response()->download("D:\\test.txt", 'newName.txt');

        /* `file` used to display the file content in the browser */
        // return response()->file("D:\\test.txt");

        /* make some content from an external service without having to write it directly */
        return response()->streamDownload(function () {
            // do something here...
        });
    }

    public function index()
    {
        /* return HTTP response using class */
        // return new \Illuminate\Http\Response('welcome');

        /* return HTTP reponse using helpers */
        // return response('hola');

        /* return HTTP response with customized header and cookie */
        return response('hola')
            ->header('X-HEADER-NAME', 'header-value')
            ->cookie('cookie-key', 'cookie-value');
    }

    /* there are also response types for view, download and JSON */
    public function indexView(User $user)
    {
        return response()
            ->view('user.show', ['user' => $user])
            ->header('Content-Type', 'text/html');
    }

    /* sometimes you wan to force user browser to download a file */
    public function indexDownload()
    {
        file_put_contents('D:\\indexDownload.txt', 'Welcome from indexDownload function');

        /* `download` used to download specific exists file where first paramtere you choose path for downloading file and second one some data you want to pass to the file */
        // return response()
        //     ->download('D:\\indexDownload.txt');

        /* if you want to delete original file after downloading use `deleteFileAfterSend` method */
        return response()
            ->download('D:\\indexDownload.txt')
            ->deleteFileAfterSend();
    }

    public function indexFile()
    {
        file_put_contents('D:\\indexDownload.txt', 'Welcome from indexDownload function');

        /* `file` response act as download except it allows the browser to display the file insead of forcing a download */
        return response()->file('D:\\indexDownload.txt');
    }

    public function indexJSON()
    {
        /* `json` method used to convert passed data to JSON and set Content-Type header to application/json */
        // return response()
        //     ->json(User::get(['name', 'email']));

        /* `setCallback` method used to categorize[set header to returned data] returned data, NOTE that `Callback` name must NOT contains whitespace */
        return response()
            ->json(User::get(['name', 'email']))
            ->setCallback('JSON');
    }

    public function DavingInRedirect()
    {
        return redirect();

        return redirect()->to('');

        /* `back` method to prevoius page, this is useful when handling and validating user input */
        return redirect()->back('');

        return redirect()->action('');

        return redirect()->away('');

        return redirect()->refresh('');

        return redirect()->route('');

        /* `withInput` used in case of the validation fails and we want return the values of inputs again */
        return back()->withInput();

        /* redirect and flash data to the session */
        return redirect()->with('key', 'value');
    }

    public function indexCustom()
    {
        // return response()->CustomJSON(User::all(['name', 'email']));

        return new CustomJSON(User::get(['name', 'email']));
    }
}
