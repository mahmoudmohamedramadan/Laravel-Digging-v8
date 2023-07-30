<?php

namespace App\Http\Controllers;

use App\{Models\User, Http\Responses\CustomJSON};

class ResponseController extends Controller
{
    public function index()
    {
        // You can return HTTP response using class or using helper
        // return new \Illuminate\Http\Response('welcome');

        // You can return an HTTP response with a custom header and cookie
        return response('hola')
            ->header('X-HEADER-NAME', 'header-value')
            ->cookie('cookie-key', 'cookie-value');
    }

    /**
     * The response view helper method.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView(User $user)
    {
        return response()->view('user.show', ['user' => $user])->header('Content-Type', 'text/html');
    }

    /**
     * The response download herlper methods.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function indexDownload()
    {
        file_put_contents('D:\\indexDownload.txt', 'Welcome from indexDownload function');

        /* `download` method used to download specific exists file where first paramtere you choose path for downloading file and second one some data you want to pass to the file */
        // return response()->download('D:\\indexDownload.txt');

        // If you want to delete original file after downloading use the `deleteFileAfterSend` method
        return response()->download('D:\\indexDownload.txt')->deleteFileAfterSend();

        // `streamDownload` method makes some content from an external service without having to write it directly
        return response()->streamDownload(function () {
            // do something here...
        });
    }

    /**
     * The response file herlper methods.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function indexFile()
    {
        file_put_contents('D:\\indexDownload.txt', 'Welcome from indexDownload function');

        /* `file` method response acts as download except it allows the browser to display the file insead of forcing a download */
        return response()->file('D:\\indexDownload.txt');
    }

    /**
     * The response json herlper methods.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexJSON()
    {
        // `json` method used to convert passed data to JSON and set Content-Type header to application/json
        // return response()->json(User::get(['name', 'email']));

        // `jsonp` method takes a callback as a header and data is the body of this header
        // return response()->jsonp('save message', ['success' => true]);

        /* `setCallback` method used to categorize[set header to returned data] returned data, NOTE that `Callback` name must not contains whitespace */
        return response()->json(User::get(['name', 'email']))->setCallback('JSON');
    }

    /**
     * The response redired herlper methods.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function diveIntoRedirect()
    {
        redirect();

        redirect()->to('');

        // `back` method to prevoius page, this is useful when handling and validating user input
        redirect()->back('');

        redirect()->action('');

        redirect()->away('');

        redirect()->refresh('');

        redirect()->route('');

        // `withInput` method used in case of the validation fails and we want return the values of inputs again
        back()->withInput();

        // `with` method redirect and flash data to the session
        return redirect()->with('key', 'value');
    }

    /**
     * The response custom class.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function indexCustom()
    {
        // return response()->CustomJSON(User::all(['name', 'email']));
        return new CustomJSON(User::get(['name', 'email']));
    }
}
