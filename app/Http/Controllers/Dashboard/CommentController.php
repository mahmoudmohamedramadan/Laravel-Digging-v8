<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\{Http\Request, Support\Facades\Gate};
use App\{Models\Post, Models\Comment, Http\Controllers\Controller};

class CommentController extends Controller
{
    public function __construct(Request $request)
    {
        // `hasValidSignature` method exists in `Kernel.php` Middleware
        if ($request->hasValidSignature()) {
            // `away` method used to redirects you to a domain outside of your application
            return redirect()->away('https://google.com');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::ScopedComments(0, 0)->get();

        return view('comment.index', ['comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* `allows` method check if the current user has ability to createa comment, NOTE you are not required to pass the currently authenticated user because Laravel do that automatically */
        if (Gate::allows('create-comment')) {
            dd('welcome authorized user!');
        }

        // Laravel allows you to perform these types of "inline" authorization checks via the `allowIf` and `denyIf`
        // Gate::allowIf(fn () => auth()->id() == 1);

        // `denies` method check if the current user has not ability to update the user
        // if (Gate::denies('create-comment')) {
        //     dd($user);
        // }

        // `forUser` method check if the ability for a given user is denies or not
        // if (Gate::forUser($user)->denies('create-comment')) {
        //     dd($user);
        // }

        return \App\Models\User::get()->toArray()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        // `can` method exists in the `Authorizable` trait which exists in `Authenticatable` class
        if (auth()->user()->can('store-comment', $post)) {
            // do something here...
        }

        $request->merge(['post_id' => $post->id, 'user_id' => $request->user_id, 'body' => $request->input('body')]);

        $validator = $this->validateInputs($request);
        Comment::create($validator);

        return redirect()->back()->with('success', 'comment added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $post->comments->find($comment->id)->update(['body' => $request->body]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        $post->comments->find($comment->id)->delete();

        return redirect()->back();
    }

    /**
     * Validate the inputs data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validateInputs($request)
    {
        return $request->validate(['post_id' => 'required', 'user_id' => 'required', 'body' => 'required|max:255']);
    }
}
