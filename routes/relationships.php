<?php

use App\Models\{User, PhoneNumber};
use Illuminate\Support\Facades\Route;

Route::get('relationships', function () {
    $user = User::find(1);
    $phoneNumberQuery = PhoneNumber::query();

    // $phoneNumbers = PhoneNumber::where('user_id', $user->id)->get();

    // You can replace the below line with the above one in the new Laravel version
    $phoneNumberQuery->whereBelongsTo($user)->get();

    /* NOTE: We called the `phoneNumbers` as a property not a method, if we called it as a property it will return a collection and the method will return a query builder */
    // return $user->phoneNumbers;

    // We save a `PhoneNumber` instance through a `user`
    /* NOTE: you are not forced to pass the `user_id` becuase we already save a `phoneNumber` instance through a `user` */

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

    /* NOTE: When you use the `save` method you save an eloquent instance model, whereas with the `create` or `createMany` you can pass an array */

    ##################################

    /* NOTE: All the previous saving data was from the parent to the child, but what if we want to do the reverse...Let's take a look at the next example */

    // Saving a `user` through the `phoneNumbers`...
    // $phone = new PhoneNumber;
    // $user = User::find(1);
    // $phone->phone_number = '000000000';
    // $phone->user()->associate($user);
    // $phone->save();

    // We sets the `user_id` to NULL in the `phone_numbers` table
    // $user = User::find(2);
    // $phone->user()->dissociate();
    // $phone->save();

    ##################################

    /* You can choose to select only records to meet particular criteria, by giving a value to the `has` method */
    // $users = User::has('phoneNumbers')->get();

    // You can retrieve all users where has more than one `phoneNumbers`
    // $users = User::has('phoneNumbers', '>', 1)->get();

    /* You can also nest the criteria (dot notation), the next example says "I want a `phoneNumbers` relationship that belongs to one `user` relationship" */
    $users = User::has('phoneNumbers.user', 1)->get();

    // You can get the SQL query from the Eloquent using `toSql` method
    $usersSQL = User::has('phoneNumbers.user', 1)->toSql();

    // If you want more power, use `whereHas`
    // $users = User::whereHas('phoneNumbers')->get();

    // We will check if the user has a `phoneNumbers` where the `user_id` equals 5
    // $users = User::whereHas('phoneNumbers', function($q) {
    //     return $q->where('user_id', 5);
    // })->get();

    // You can also shorten the upper example
    // $users = User::whereHas('phoneNumbers', fn ($q) => $q->where('user_id', 5))->get();

    // In addition, you can use `whereRelation`
    // $users = User::whereRelation('phoneNumbers', 'user_id', '=', 3)->get();

    // We limit our results based on the absence of a relationship
    // $users = User::doesntHave('phoneNumbers')->get();

    // return $users;

    ##################################

    /* You can access the `pivot_table` (category_product) using `pivot` keyword, NOTE you can access `pivot` even if `categories` relationship not has a `withPivot` method */
    // foreach (\App\Models\Product::find(1)->categories as $category) {
    //     dd($category->category_product_pivot_table->category_id);
    // }

    ##################################

    // $users = User::get();

    /* The below type is called `deferred count loading`, which means you load the relation count after the parent model loaded */
    // return $users->load('phoneNumbers');
    // return $users->loadMissing('phoneNumbers');

    // Get the count of the items in each relationships
    // $usersCount = User::withCount('phoneNumbers')->get();

    /* The `with*` methods all of them accepts the relation name as a first argument and the column that you want to get the max as a second argument */
    // $usersMax = User::withMax('phoneNumbers', 'user_id')->get();
    // $usersMin = User::withMin('phoneNumbers', 'user_id')->get();
    // $usersAvg = User::withAvg('phoneNumbers', 'user_id')->get();

    // To get the result of any of `with*`. Write `{relation}_{function}_{columnName}`
    /* NOTE: When your relation was in camel case you must access it in snake case such as 'phoneNumber` must be 'phone_numbers` */
    // $usersSum = User::withSum('phoneNumbers', 'user_id')->get();
    // $usersSum->first()->phone_numbers_sum_user_id;

    // $usersExists = PhoneNumber::withExists('user', 'id')->get();

    // You can create an alias for the relationship result using `as`
    //$phoneNumbersCount = PhoneNumber::withCount('user as custom_user_count')->get();

    $user = User::find(1);

    /* We get the departments which them `departmentable_type` is `\App\Models\User` and `departmentable_id` is `1` */
    // return \App\Models\Department::query()
    //     ->where('departmentable_type', $user->getMorphClass())
    //     ->where('departmentable_id', $user->getKey())
    //     ->get();

    /* In a new Laravel version you can use the following awesome syntax. here you can pass `departmentable` without passing the `type` and `id` */
    return \App\Models\Department::query()
        ->whereMorphedTo('departmentable', $user)
        ->get();
});
