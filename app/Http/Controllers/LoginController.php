<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /* The difference between `Authentication` and `Authorization` is
    Authentication | is verifing who someone is, and allowing them to act as that person
    ============== | ==================================================================
    Authorization  | is about determining whether authenticated user is allowed (authorized) to perform specific behavoir */

    /**
     * Return the manual login form
     *
     * @return \Illuminate\View\View
     */
    public function loginForm()
    {
        return view('manual_auth.login');
    }

    /* You can use `@method` to make the IDE know that the methods exists. but when asking the IDE to jump to the declaration of the method, one way to not get stuck and to kow that method exist in that place there is to add an `@see` */

    // Read about `method`, and `see` annotations: https://stackoverflow.com/q/46756130/11019205

    /**
     * Login a user into dashboard manually
     *
     * @method static bool attempt(array $credentials = [], bool $remember = false)
     * @see \Illuminate\Contracts\Auth\Guard
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->only('email', 'password'),
            ['email' => 'required|email', 'password' => 'required'],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = ['email' => $request->email, 'password' => $request->password];

        // `attempt` method see whether the provided credentails match any real users
        // NOTE: `filled` method check if this key is filled or not
        $authentication = auth()->guard('web')
            ->attempt($credentials, $request->filled('remember_me'));

        /* If you want to check manually whether the current user was authenticated by a remember me token or not, us the `viaRemember` method */
        // $viaRemember = auth()->guard('web')->viaRemember();

        // Also, you can log user into application with his id using the `loginUsingId`
        // auth()->loginUsingId(2);

        /* In addition, you can use the `login` method to log a full user object [or any object implements Illuminate\Contracts\Auth\Authenticatable contract] */
        // auth()->login(User::find(1));

        // Also, you can log user into application without using `session` or `cookie`
        // auth()->once($credentials);
        // auth()->onceUsingId(1);

        if ($authentication) {
            return redirect()->to('/home');
        }

        session()->flash('error', 'invalid credentails');

        return redirect()->back();
    }

    public function logout()
    {
        auth()->guard('web')->logout();

        return redirect()->route('login');
    }
}
