<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\{Http\Request, Support\Facades\View};
use App\{Models\User, Models\Post, Http\Controllers\Controller};

class PostController extends Controller
{
    /* In case of you want to check the authorization for every resource controller's methods [index, create, store, show, edit, update, destroy] you can refactoring your code via using `authorizeResource` method in constructor */
    public function __construct()
    {
        // $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::get();

        // `valueOrFail` method gets a single column's value from the first result of a query or throws an exception
        // return Post::where('id', 1)->valueOrFail('title');

        // You can call your accessor in pascal case
        // $posts->UserWithBody;

        // You can call your accessor also in snack case
        // $posts->user_with_body;

        /* The `chunk` method will retrieve a subset of Eloquent models, passing them to a closure for processing. Since only the current chunk of Eloquent models is retrieved at a time, the `chunk` method will provide significantly reduced memory usage when working with a large number of models */
        // $posts->chunk(3, function ($posts) {
        //     foreach ($posts as $key => $value) {
        //     }
        // });

        /* If you are filtering the results of the `chunk` method based on a column that you will also be updating while iterating over the results, you should use the `chunkById` method. Using the `chunk` method in these scenarios could lead to unexpected and inconsistent results. Internally, the `chunkById` method will always retrieve models with an `id` column greater than the last model in the previous `chunk` */
        // $posts->chunkById(3, function ($posts) {
        //     $posts->each()->update(['user_id' => 1]);
        // }, 'id');

        // For more info watch this video: https://youtu.be/aQCHmB4Uh0Q

        /* The `lazy` method works similarly to the `chunk` method in the sense that, behind the scenes, it executes the query in `chunks`. However, instead of passing each `chunk` directly into a callback as is, the `lazy` method returns a flattened `LazyCollection` of Eloquent models, which lets you interact with the results as a single stream */
        $posts = $posts->lazy();

        /* If you are filtering the results of the lazy method based on a column that you will also be updating while iterating over the results, you should use the `lazyById` method. Internally, the `lazyById` method will always retrieve models with an id column greater than the last model in the previous chunk */
        // $posts->lazyById(3, 'id')->each()->update(['user_id' => 1]);

        return view('post.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();

        // `exists` method check if the given view exists or not
        if (View::exists('post.create')) {
            // the below line is equivalent to the `view` helper method
            return View::make('post.create', ['users' => $users]);
        }

        // You can also pass an array in the first argument of the `first` method and that means give me the first view
        return View::first(['post.create'], ['users' => $users]);

        return view('post.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validate = $this->validateInput($request);

            // You can also save using the below form
            $postModel = '\App\Models\Post';
            $post_id = $postModel::insertGetId($validate);

            session()->flash('success', 'data saved successfully');
            return redirect()->route('posts.show', $post_id);
        } catch (\Exception | \Error $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Show the profile for a given user.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        /* When you replicate (duplicate) the post, you do not replicate the relationship, NOTE also that the replication problem does when you replicates the parent instance then access its child relation */
        // $clonedPost = $post->replicate();
        // $clonedPost->title = 'title_value';

        // You can also use the below form
        // $clonedPost = $post->replicate()->fill(['title' => 'title_value']);

        /* To exclude one or more attributes from being replicated to the new model, you may pass an array to the `replicate` method */
        // $clonedPost = $post->replicate(['title']);

        // You should save the replicated post
        // $clonedPost->save();

        // If you already have a model instance, you may use the `fill` method to populate it with an array of attributes
        // $post->fill(['title' => 'Save Title Using `fill` method']);

        /* To solve that problem of relationship replication use: `bkwld/cloner` package
        > NOTE in case of `belongsTo` relationship, the relationship will be replicated also, otherwise you need to add `cloneable_relations` attribute */

        return view('post.show', ['post' => $post, 'users' =>  User::get(), 'comments' => $post->comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', ['post' => $post, 'users' => User::get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        /* So we do not need to use `Gate` class to check if user is authorize to do some actions because parent Controller has `AuthorizesRequests` trait which contains three methods for user authorization So we can replace this way with next one */
        // Gate::cannot('update-posts', function ($post) {
        //     if($post->id == 1) {
        //         return abort(403);
        //     }
        // });

        /* `authorize` method allows you to check user authorization by passed the key which custom added with custom condition in `AuthServiceProvider` also there is another way to check authorization */
        // $this->authorize('update-post', $post);

        /* The difference between `authorize` and `authorizeForUser` that `authorizeForUser` we passed any user we want but `authorize` always check for authenticated user */
        $this->authorizeForUser(auth()->user(), 'update-post', $post);
        $validate = $this->validateInput($request);
        $post->update($validate);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (count($post->comments) > 0) {
            $post->comments->delete();
        }

        $post->delete();

        return redirect()->route('posts.index');
    }

    /**
     * Validate post inputs
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function validateInput($request)
    {
        return $request->validate([
            'user_id' => 'required', 'title' => 'required|max:255', 'body' => 'required|max:255',
        ]);
    }
}
