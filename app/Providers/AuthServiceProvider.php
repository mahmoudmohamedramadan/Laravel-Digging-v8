<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\{Models\User, Policies\UserPolicy};
use Illuminate\Support\Facades\{Auth, Gate};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensCan([
            'list-clips' => 'List sound clips',
            'add-delete-clips' => 'List sound clips',
        ]);

        // Auth::viaRequest('web', function ($request) {
        //     return User::where('id', 1)->get();
        // });

        // $this->app['auth']->viaRequest('web', function ($request) {
        //     return User::where('id', 1)->get();
        // });

        /* `before` method runs before all the defined closures and you can optionally override them */
        Gate::before(function ($user, $ability) {
            // do some conditions here...
        });

        /* here we can define the authorization rule is called an ability and is comprised of two things: a string key and closure
        ## First to define the ability you're providing to a user as {verb}-{modelName}: `update-user` and `create-phone`
        ## Second the closure in first parameter the currently authenticated user and all parameters after that will be the object(s) you're checking for access */
        Gate::define('update-user', function ($user) {
            if ($user->id == auth()->id()) {
                return true;
            }

            return false;
        });

        /* you can also define your gate without closure */
        Gate::define('delete-user', 'App\\Models\\User@checkAbility');

        /* you can also pass the closure to point to specific method in the `CommentPolicy`(actually NOT exists) */
        // Gate::define('delete-user', [\App\Policies\CommentPolicy::class, 'create']);

        Gate::define('create-comment', function ($user, $comment) {
            if ($user->id == auth()->id() and $comment === 'App\\Models\\Comment') {
                return true;
            }

            return false;
        });

        Gate::define('store-comment', function ($user, $post) {
            if ($user->id == auth()->id() or $post->user_id == auth()->id()) {
                return true;
            }

            return false;
        });

        Gate::define('update-comment', function ($user, $comment) {
            if ($user->id == $comment->user_id) {
                return true;
            }

            return false;
        });

        Gate::define('index-post', function ($user, $post) {
            if ($user->id == $post->user_id) {
                return true;
            }

            return false;
        });

        /* the most common use to ACL(Access Control List) to define access to resources
        the resource method makes it possible to apply the most common gates, view, create, update, delete
        Gate::resource('photos', 'App\\Polices\\PhotoPolicy');

        ### this is equivalent defining the following
        Gate::define('photos.view', 'App\Policies\\PhotoPolicy@view');
        Gate::define('photos.viewAny', 'App\Policies\\PhotoPolicy@viewAny');
        Gate::define('photos.create', 'App\Policies\\PhotoPolicy@create');
        Gate::define('photos.update', 'App\Policies\\PhotoPolicy@update');
        Gate::define('photos.delete', 'App\Policies\\PhotoPolicy@delete'); */
    }
}
