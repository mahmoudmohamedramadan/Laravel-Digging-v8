<?php

use App\Models\{
    Dog,
    User,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DogAPIController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sendHeader', function () {
    /* any request to GitHub's API will return headrs detailing the current user's rate limiting status
    x-ratelimit-limit: 5000 */
    return response(Dog::get())->header('X-Greatness-Index', '12');
});

Route::get('readHeader', function (Request $request) {
    return $request->header('Accept');
});

Route::get('sortAPI', function (Request $request) {
    /* there isn't ant api tool for sorting */
    // $sortColumn = $request->input('sort', 'id');
    // $sortDirection = str_starts_with($sortColumn, '-') ? 'desc' : 'asc';

    // return Dog::orderBy($sortColumn, $sortDirection)->paginate(10);
    /* multiple sort key */
    $sorts = explode(', ', $request->input('sort', 'id'));

    $query = Dog::query();

    foreach ($sorts as $sortColumn) {
        $sortDirection = str_starts_with($sortColumn, '-') ? 'desc' : 'asc';
        $sortColumn = ltrim($sortColumn, '-');

        $query->orderBy($sortColumn, $sortDirection);
    }

    return $query->paginate(10);
});

Route::get('filterAPI', function (Request $request) {
    $query = Dog::query();

    $query->when($request->filled('filter'), function ($query) {
        [$criteria, $value] = explode(':', request('filter'));
        return $query->where($criteria, $value);
    });

    return $query->paginate(10);
});

Route::get('transformer/users/{userId}', function ($userId) {
    /* Transformers are helpful becuase they give you more control, isolate API-specific login away from the model itself */
    return new \App\UserTransfomer(User::findOrFail($userId));
});

Route::get('nestingAndRelationships/users/{userId}', function ($userId) {
    /* read this https://apisyouwonthate.com/ */
    explode(', ', request()->input('include', ''));

    return new App\NestingAndRelationships(User::findOrFail($userId));
});

Route::apiResource('dogs', DogAPIController::class);
