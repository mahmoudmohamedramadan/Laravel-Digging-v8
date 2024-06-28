<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\{Http\Request, Validation\Rules\Password};
use App\{Models\User, Scopes\GlobalScope, Http\Controllers\Controller};
use Illuminate\Support\{MessageBag, Facades\Hash, Facades\Cache, Facades\Validator};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // $users = User::where('email', 'like', '%.com%')->get();

        // when you try to get all users, the global scope will be called automatically
        // $users = User::get();

        // Here we return only these columns
        /* NOTE: When you pass two parameters to pluck method will return an array with a key of second parameter and value of first one like this 1 => "Mahmoud Mohamed Ramadan" */
        // $users = User::all()->pluck('name', 'id');

        // we can pass columns name which we need only
        // $users = User::all(['id', 'name']);

        /* To remove global scope you can use three ways, the first one is to specify the name of the global scope */
        $users = User::withoutGlobalScope(GlobalScope::class)->paginate(10);

        /* By default, links generated by the paginator will match the current request's URI. However, the paginator's withPath method allows you to customize the URI used by the paginator when generating links. For example, if you want the paginator to generate links like `http://example.com/admin/users?page=N`, you should pass `/admin/users` to the `withPath` method */
        // $users->withPath('/admin/users');

        /* Sometimes you may need to render two separate paginators on a single screen that is rendered by your application. However, if both paginator instances use the page query string parameter to store the current page, the two paginator's will conflict. To resolve this conflict, you may pass the name of the query string parameter you wish to use to store the paginator's current page via the third argument provided to the `paginate`, `simplePaginate`, and `cursorPaginate` methods */
        // $users = User::withoutGlobalScope(GlobalScope::class)->paginate(10, ['*'], 'users');

        // $users = User::paginate(10);

        // You can also append some qurey string to the exists using `appends` method
        // $users->appends(['sort' => 'asc']);

        // $users = User::withoutGlobalScope(GlobalScope::class)->simplePaginate(10);

        /* The cursor is an encoded string containing the location that the next paginated query should start paginating and the direction that it should paginate */
        // $users = User::withoutGlobalScope(GlobalScope::class)->cursorPaginate(10);

        // For more info: https://dev.to/jackmarchant/offset-and-cursor-pagination-explained-b89

        /* `cursorPagination` How this is working,...Suppose you have 20 records and want to show 5, the system works from  top to bottom and then from bottom to top and so on? The first query will tell you, give me such and such, since the ID was less than 6, so he answers from the first 1 to 5, but I want to keep thinking about the last row I am standing in to answer from him, and he says I will answer from 1 to 6, but in descending order and my limit is 5 again, he will tell you So what do you say when it is greater than 5 and my limit is 5 and the order is ascending to the target? */

        // If you want to append a query string with the current page number use `withQueryString`
        // $users = User::withoutGlobalScope(GlobalScope::class)->paginate(10)->withQueryString();

        // The second one is to specify the name of global scopes
        // $users = User::withoutGlobalScopes([GlobalScope::class])->get();

        // The third one is to remove all global scopes without passing the name of scopes
        // $users = User::withoutGlobalScopes()->get();

        // First param is the key and the second is time to leave[forgot] and the third is callback
        // return Cache::remember('users', 20, function() {
        //     return User::get(['name']);
        // });

        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* `firstOrCreate` method will attempt to find record using given key/value pairs, if this user not found a record will be inserted */
        /* NOTE: this method is look like `firstOrNew` but the difference that `firstOrNew` has not persisted yet in database and you should save it manually using `save` method */
        // $user = User::firstOrCreate($this->getUserData($request));

        // $user = User::firstOrNew(
        //     ['name' => $request->name],
        //     ['email' => $request->email],
        //     ['locale' => $request->locale],
        //     ['password' => $request->password],
        // );

        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->loacle = $request->loacle;
        // $user->password = 'admin';

        // $user = new User($this->getUserData($request));

        // $user = User::make($this->getUserData($request));
        // $user->save();

        /* You can use `firstOr` function to determine what the action will happen in case of the user doesn't exist */
        // return User::where('id', 1000)->firstOr(fn () => abort(404));

        /* If the password input not exist so abort the request, `abort_unless` is opposite to `abbort_if` */
        abort_unless($request->has('password'), 404);
        // abort_if(!$request->has('password'), 405);

        /* When you use email validation use `email:rfc,dns` to ensure that email is a valid according to `rfc`, and `dns` */
        // For more info: https://laravel.com/docs/8.x/validation#rule-email
        $validator = Validator::make($request->only('name', 'email', 'locale', 'password'), [
            'name' => ['required'], 'email' => ['required', 'email:rfc,dns'], 'locale' => ['required', 'in:en,ar'],
            'password' => ['required', Password::min(8)->letters()->symbols()->numbers()->mixedCase()],
        ]);

        /* `min` method in the `Password` rule means that require at least 8 characters, `letters` means that require at least one letter, `symbols` means that require at least one symbol, `numbers` means that require at least one number , and `mixedCase` means that require at least one uppercase and one lowercase letter */

        // $bag = new MessageBag($validator);

        // Also you can send error messages only
        $bag = new MessageBag($validator->errors()->messages());

        if ($validator->fails()) {
            // So you can pass to `withErrors` method the MessageBag result
            return back()->withErrors($bag, 'createUserErrors')->withInput();

            /* But what if you have two forms in one page like singin and singup how you can differentiate them ? To differentiate them pass the second paramter, the second one express about the name of MessageBag and to deal with this key(second parameter) in blade file use this line `$errors->messageBagName->first('inputName')` */
            return back()->withErrors($validator, 'messageBagName')->withInput();
        }

        $user = User::create($this->getUserData($request));

        /* Before embarking use action method, make sure that there is a route visit this controller and method */
        // return redirect()->action('UserController@show', ['user' => $user->id]);

        // Tuple form
        return redirect()->action([UserController::class, 'show'], ['user' => $user->id]);
    }

    /**
     * Show the profile for a given user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);

        // `secure` method like `redirect()->to()` but in HTTPS connection
        // return redirect()->secure('home');

        // `home` method redirects you to route named `home`
        // return redirect()->home();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        User::findOrFail($user->id)->update($this->getUserData($request));

        /* `refresh` method redirects you one step back, ex: if you in `users/1/edit` after calling this method you will redirect to `users/1` */
        return redirect()->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // `destroy` method take an array of id's rows which you want to delete
        // return User::destroy([20, 24]);

        /* After we have added the `softDelete` trait and try to delete the user he will not delete permanently but the `deleted_at` column will be filled with the timestamp of the deletes time */
        // $user->delete();

        /* You can use `deleteOrFail` also and, in case something wrong happens will fail because this method use the transaction */
        $user->deleteOrFail();

        return redirect('/users');

        // Also you can redirect using `to` method
        // return redirect()->to('/users');
    }

    /**
     * Get the user data from the request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'locale' => $request->locale,
            'password' => Hash::make($request->password),
        ];
    }

    /**
     * Get the softDeletes users
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function trashedUsers()
    {
        $users  = User::onlyTrashed()->get();

        return view('user.trashed', compact('users'));
    }

    /**
     * Restore the deleted user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restoreUser(Request $request)
    {
        /* NOTE: We could not use route binding with `get` method because user is already deleted and we can not find him So, we used the `onlyTrashed` method to search in deleted users */
        $user = User::onlyTrashed()->get()->find($request->route()->parameter('user'));

        // When we want to see the soft delete users write `withTrashed`
        // return User::withTrashed()->get();

        // When we want to get trashed users only use `onlyTrashed`
        // return User::onlyTrashed()->get();

        // To check user if soft deleted or not use `trashed` method
        if ($user->trashed()) {
            // To restore soft deleted use `restore` method
            $user->restore();
        }

        return redirect()->route('users.trashed');
    }

    /**
     * Force delete the given user id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forceDeleteUser(Request $request)
    {
        $user = User::onlyTrashed()->get()->find($request->route()->parameter('user'));

        if ($user->trashed()) {
            // `forceDelete` method used to delete user permentely
            $user->forceDelete();
        }

        return redirect()->route('users.trashed');
    }

    public function getUsersForInjectDirective()
    {
        return User::get();
    }
}
