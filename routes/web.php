<?php

use App\Facades\StudentFacade;
use App\Http\Resources\DogResource;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\{Auth, Http, Route};
use App\Http\Controllers\Dashboard\{PostController, UserController, CommentController, UserCommentsController};

/* `verify` that passed to `routes` method of the `Auth` used to enable Laravel's email verification service, which requires new users to verify email address to have access to dashboard, NOTE there is a verified middleware in `\App\Http\Kernel.php` to check if the email is verified or not also in the routes method you can prevent user from `registration` and/or `password resetting` */

Auth::routes(['verify' => false, 'register' => true, 'reset' => false]);

Route::get('logout', [LoginController::class, 'logout']);
Route::get('logoutOtherDevices', function () {
    /* `logoutOtherDevices` method log the user out from all devices which he used to login and this method takes two parameters the first one the password of current user and second the attribute which you want to use it to pass attribute's value NOTE after pass your password it'll be hashed again */
    auth()->logoutOtherDevices('admin');

    return redirect('/user/login');
});

Route::view('home', 'home');
Route::view('/', 'welcome')->name('welcome');

// Route::group(['prefix' => 'user/login'], function () {
//     Route::get('/', [LoginController::class, 'loginForm'])->name('users.formLogin');
//     Route::post('/', [LoginController::class, 'login'])->name('users.login');
// });

/* You may use the `controller` method to define the common controller for all of the routes within the group */
Route::controller(LoginController::class)->group(function () {
    Route::get('/user/login', 'loginForm')->name('users.formLogin');
    Route::post('/user/login', 'login')->name('users.login');
});

Route::middleware('auth')->group(function () {
    // Here we used the custom gate that we have created in the `AuthServiceProvider`
    Route::resource('users', UserController::class)->middleware('can:update-user');
    Route::resources([
        'posts' => PostController::class,
    ]);

    Route::get('trashedUsers', [UserController::class, 'trashedUsers'])->name('users.trashed');
    Route::get('restoreUser/{user}', [UserController::class, 'restoreUser'])->name('users.restore');
    Route::delete('forceDeleteUser/{user}', [UserController::class, 'forceDeleteUser'])
        ->name('users.forceDelete');

    Route::group(['prefix' => 'posts/{post}/comments'], function () {
        Route::post('/', [CommentController::class, 'store'])->name('comments.store');

        /* NOTE: We can pass to custom gate parameter like comment [`bounded route model`] after comma
        but what if not required to pass a model instance like `create` So, you can pass a model like `Comment` */
        Route::get('create', function () {
            dd('create comment route');
        })->middleware('can:create-comment,App\\Models\\Comment');

        Route::patch('{comment}', [CommentController::class, 'update'])->name('comments.update')
            ->middleware('can:update-comment,comment');

        Route::delete('{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });

    Route::name('user.')->prefix('user')->group(function () {
        Route::name('comments.')->prefix('{user}/comments')->group(function () {
            Route::get('{comment}', [UserCommentsController::class, 'show'])->name('show');
        });
    });
});

/* `/redirect` route must be in the consumer website (any website provides its users a way for authorization using Laravel-Digging) it will redirect to the service provider (Laravel-Digging) for authorization and finally will return to the `redirect_url` */
Route::get('/redirect', function () {
    /* `redirect_uri` should match `redirect` column in `oauth_clients` table of the service provider (Laravel-Digging), NOTE Once a user choose to accept or reject the authorization, Passport will redirect that user back to the `redirect_uri` */
    $query = http_build_query([
        'client_id' => '1',
        'redirect_uri' => 'http://localhost:8000/passport/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    /* NOTE: The url in the `redirect` was belongs to the service provider(http://laravel-digging.com/oauth/autorize) but not all websites uses passport package to redirect to `oauth/authorize` So you should always redirect client to your project which actually uses passport package */
    return redirect('http://laravel-digging.com/oauth/authorize?' . $query);
});

/* `/passport/callback` must be in consumer website and when the user visit `/redirect`, the request will go for the service provider(Laravel-Digging) for authorization then go back for `/passport/callback` */
Route::get('/passport/callback', function () {
    abort_if(request()->has('error'), 403);

    return Http::asForm()->post('http://laravel-digging.com/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => '1',
        'client_secret' => 'rZkmvFBqTu00hzb48k6Siutm4uqO6I0NkxbKE9y4',
        'redirect_uri' => 'http://localhost:8000/passport/callback',
        'code' => request()->code,
    ])->json();
});

Route::get('dogCollection', function () {
    // Here we will call `DogResource` directly
    // return new DogResource(\App\Models\Dog::find(1));

    /* We will call `DogResource` directly, and the difference between the below and the upper line is that in case we call `collection` we must pass an array but the upper line we must pass a model instance */
    return DogResource::collection(\App\Models\Dog::get());

    // You can use the below line, and in that case the pagination data will be printed
    // return DogResource::collection(\App\Models\Dog::paginate(10));

    // The below line is equal to the upper line
    // return new \App\Http\Resources\DogCollection(\App\Models\Dog::get());

    // Also you can do this form
    // return DogResource::collection(Post::get());
});

Route::get('macroableStr', function () {
    // return \Illuminate\Support\Str::customSplit('00064654654');
    return \Illuminate\Support\Str::customSplitOne('00064654654');
});

// You can use this form in case you have many routes have the same closure
$facadeClosure = function () {
    // You can use `printStudenData` as if it is statically defined using facades
    return StudentFacade::printStudenData();
};
Route::get('customFacade', $facadeClosure);
