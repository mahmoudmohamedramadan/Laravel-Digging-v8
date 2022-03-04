<?php

use App\Models\User;
use App\Models\PhoneNumber;
use Illuminate\Support\Facades\Route;

Route::get('relationships', function () {
    $user = User::find(1);
    $phoneNumberQuery = PhoneNumber::query();

    /* a new version in Laravel, instead of saying `PhoneNumber::where('user_id', $user->id)->get()` you can use the next line */
    $phoneNumberQuery->whereBelongsTo($user)->get();

    /* NOTE that we called the `phoneNumbers` as a property NOT a method, if we called it as a property it will return a full eloquent instance and the method will return a collection instead of model instance...
    so when we called as a method instead of processing relationship, it will return a pre-scoped query builder */
    // return $user->phoneNumbers;

    /* here we save a `PhoneNumber` instance through a `user`, NOTE that you are NOT forced to pass the `user_id` becuase we already save a `phoneNumber` instance through a `user` */
    // $phone = new PhoneNumber();
    // $phone->phone_number = '22222';
    // $user->phoneNumbers()->save($phone);

    //////// OR
    // $phoneNumbers_1 = new PhoneNumber();
    // $phoneNumbers_1->phone_number = '000546546003';

    // $phoneNumbers_2 = new PhoneNumber();
    // $phoneNumbers_2->phone_number = '000546546005';

    // $user->phoneNumbers()->saveMany([$phoneNumbers_1, $phoneNumbers_2]);

    //////// OR
    // $user->phoneNumbers()->create([
    //     'phone_number' => '00184897387',
    // ]);

    //////// OR
    // $user->phoneNumbers()->createMany([
    //     ['phone_number' => '01000000600'],
    //     ['phone_number' => '01000000050'],
    // ]);

    // return $user->phoneNumbers;

    /* NOTE that when you save, you must save an eloquent instance model, whereas in case you will use `create` or `createMany` you must pass an array */

    ##################################

    /* NOTE that all the previous saving data was through the parent table to the child tablr, BUT what if we what to save data from child to parent...let's look at the next example */

    /* save a `user` through a `phoneNumbers`, NOTE that you should give right data about the user that you want to associate with a `phoneNumbers` like `user_id`, logically you want to associate a `user` to a `phoneNumber` so, we will prepare the `phone_number` column and find the user that we want to associate to the `phoneNumber` */
    // $phone = new PhoneNumber;
    // $user = User::find(1);
    // $phone->phone_number = '000000000';
    // $phone->user()->associate($user);
    // $phone->save();

    /* here we make the `user_id` equlas NULL in the `phone_numbers` tables using `phone_numbers.id` and `phone_numbers.user_id` */
    // $user = User::find(2);
    // $phone->user()->dissociate($user);
    // $phone->save();

    ##################################

    /* you can choose to select only records to meet particular criteria...write in the has parameter the name of relationship */
    // $users = User::has('phoneNumbers')->get();

    /* or you can retrieve all users where has more than one `phoneNumbers` */
    // $users = User::has('phoneNumbers', '>', 1)->get();

    /* also you can nest the criteria(dot notation), the next example says "I want a `phoneNumbers` relationship that belongs to one `user` relationship" */
    $users = User::has('phoneNumbers.user', 1)->get();

    /* if you want more power, use `whereHas` */
    // $users = User::whereHas('phoneNumbers')->get();

    /* here will check if the user has `phoneNumbers` also where the `user_id` equlas to 5 */
    // $users = User::whereHas('phoneNumbers', function($q) {
    //     return $q->where('user_id', 5);
    // })->get();

    /* there is a easy manner for the upper example */
    // $users = User::whereHas('phoneNumbers', fn ($q) => $q->where('user_id', 1))->get();

    /* `whereRelation` takes what you'll write in `where` inside the closure like the upper example */
    // $users = User::whereRelation('phoneNumbers', 'user_id', '=', 3)->get();

    /* here we limit our results based on the absence of a relationship */
    // $users = User::doesntHave('phoneNumbers')->get();

    // return $users;

    ##################################

    // foreach (\App\Models\Product::find(1)->categories as $category) {
    /* you can access the `pivot_table` (category_product) using `pivot` keyword, NOTE that you can access `pivot` even if `categories` relationship NOT has a `withPivot` method */
    //     dd($category->category_product_pivot_tabel->category_id);
    // }

    ##################################

    // $users = User::get();

    /* this type called `defferd count loading`, that means you load the relation count after the parent model loaded */
    // return $users->load('phoneNumbers');
    // return $users->loadMissing('phoneNumbers');

    /* get count of items in each relationships, the name of relationship suffixed with count in snake case */
    // $usersCount = User::withCount('phoneNumbers')->get();

    /* `withMax`, `withMin`, ..., `withExists` all of them accepts the relation name as a first argument and the column that you want to get the max as a second argument */
    // $usersMax = User::withMax('phoneNumbers', 'user_id')->get();
    // $usersMin = User::withMin('phoneNumbers', 'user_id')->get();
    // $usersAvg = User::withAvg('phoneNumbers', 'user_id')->get();

    /* to get the result of any of `withSum`, `withMax`... write {relation}_{function}_{columnName} NOTE that when your relation in camel case you must access it in snake case such as 'phoneNumber` must be 'phone_numbers` */
    // $usersSum = User::withSum('phoneNumbers', 'user_id')->get();
    // $usersSum->first()->phone_numbers_sum_user_id;

    // $usersExists = PhoneNumber::withExists('user', 'id')->get();

    /* you can also alias the relationship result using `as` */
    //$phoneNumbersCount = PhoneNumber::withCount('user as custom_user_count')->get();

    $user = User::find(1);

    /* here we get the departments which them `departmentable_type` is `\App\Models\User` and `departmentable_id` is `1`*/
    // return \App\Models\Department::query()
    //     ->where('departmentable_type', $user->getMorphClass())
    //     ->where('departmentable_id', $user->getKey())
    //     ->get();

    /* in a new version of Laravel you can use this awesome syntax. here you can pass `departmentable` WITHOUT passing the `type` and `id` */
    return \App\Models\Department::query()
        ->whereMorphedTo('departmentable', $user)
        ->get();
});
