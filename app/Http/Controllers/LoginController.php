<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /* The difference between `Authentication` and `Authorization` is
    Authentication | is verifing who someone is, and allowing them to act as that person
    ============== | ==================================================================
    Authorization  | is about determining whether authenticated user is allowed(authorized) to perform specific behavoir */

    /**
     * Return the manual login form
     *
     * @return \Illuminate\View\View
     */
    public function loginForm()
    {
        return view('manual_auth.login');
    }

    /* you can use `@method` to make the IDE know that the methods exists. But when asking the IDE to jump to the declaration of the method, one way to not get stuck and to kow that method exist in that place there is to add an `@see` row */

    /* Read about `method`, and `see` annotations: https://stackoverflow.com/q/46756130/11019205 */

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

        /* So if you want to handle remember me make sure that remember_me column exists in users table, in case of you pass true[whatever value of remember me] as a second parameter user's credentails saved in cookie in your pc and does NOT logout
        NOTE that `filled` method check if this key is filled or NOT if it has a value will return true else return false */
        $authentication = auth()->guard('web')->attempt($credentials, $request->filled('remember_me'));

        /* if you want to check manually wheter the current user was authenticated by a remember me token or NOT,viaRemember method returns true if user authenticated via a remember token */
        // $viaRemember = auth()->guard('web')->viaRemember();

        /* attempt method see wheter the provided credentails match any real users, If so login them in
        BUT sometimes it'll be valuable for you to able to choose to log a user in on your own */
        // auth()->loginUsingId(2);

        /* second you can use login method and pass user object [or any object implements Illuminate\Contracts\Auth\Authenticatable contract] */
        // auth()->login(User::find(1));

        /* third and fourth we log user into application without using session or cookie */
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
