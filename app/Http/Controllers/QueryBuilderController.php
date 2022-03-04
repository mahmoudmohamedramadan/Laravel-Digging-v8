<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function index()
    {
        /* Fluent Interface: is the method chaning provide simpler API to the end user like lower line... */
        // return DB::table('users')->select('*')->get();

        /* `statement` method return true if the query was success else will return false, NOTE that Some database statements do NOT return any value */
        // return DB::statement('select * from users');

        // DB::unprepared('select * from users');

        /* Since `unprepared` statements do NOT bind parameters, they may be vulnerable to SQL injection. You should never allow user controlled values within an unprepared statement. */

        /* When using the DB facade's `statement` and `unprepared` methods within transactions you must be careful to avoid statements that cause implicit commits. more info: https://answers.sap.com/answers/5625146/view.html */

        /* If your application defines multiple connections in your `config/database.php` configuration file, you may access each connection via the `connection` method provided by the `DB` facade */
        // DB::connection('sqlite')->select('');

        // return DB::select('select * from users where id = ? and name = ?', [ 1, 'Willow Rau']);

        // return DB::table('users')->get();

        /* you can name the parameters for clarity */
        // return DB::select('select * from users where id = :id', ['id' => 1]);

        // return DB::insert(
        //     'insert into users (name, email, password) values (?, ?, ?)',
        //     [1, 'admin@gmail.com', Hash::make('admin')]
        // );

        /* you can also create an alias for a column */
        // return DB::table('users')->select('name', 'email as Email')->get();

        // return DB::table('users')
        //     ->select('name')
        //     ->addSelect('email as Email')
        //     ->get();

        /* you can also add multiple rows */
        // return DB::table('users')
        //     ->insert([
        //         ['name' => 'Mahmoud Ramadan', 'email' => 'mr@gmail.com', 'password' => Hash::make('admin')],
        //         ['name' => 'Mahmoud Ali', 'email' => 'ma@gmail.com', 'password' => Hash::make('admin')],
        //     ]);

        /* insert one row then give me its id */
        // return DB::table('users')
        //     ->insertGetId([
        //         'name' => 'Osama Updated', 'email' => 'ou@gmail.com', 'password' => Hash::make('admin'),
        //     ]);

        /* The `insertOrIgnore` method will ignore errors while inserting records into the database: */
        // return DB::table('users')->insertOrIgnore([
        //     'name' => 'Osama Updated', 'email' => 'ou@gmail.com', 'password' => Hash::make('admin'),
        // ]);

        /* Sometimes you may want to update an existing record in the database or create it if no matching record exists. In this scenario, the `updateOrInsert` method may be used. The `updateOrInsert` method accepts two arguments: an array of conditions by which to find the record, and an array of column and value pairs indicating the columns to be updated.

        The `updateOrInsert` method will attempt to locate a matching database record using the first argument's column and value pairs. If the record exists, it will be updated with the values in the second argument. If the record can not be found, a new record will be inserted with the merged attributes of both arguments */
        return DB::table('users')
            ->updateOrInsert(
                ['email' => 'john@example.com', 'name' => 'John'],
                ['lang' => 'fr']
            );
    }

    public function conditionsSQL()
    {
        /* second parameter of `where` method is comparison operator, if comparison operator is `=` you can drop it. */
        // return DB::table('users')
        //     ->where('created_at', '<', date('Y-m-d h:i:s'))
        //     ->get();

        // return DB::table('users')
        //     ->where([
        //         ['created_at', '<', date('Y-m-d h:i:s')],
        //         ['id', 1]
        //     ])
        //     ->get();

        // return DB::table('users')
        //     ->where('created_at', '<', date('Y-m-d h:i:s'))
        //     ->where('id', 1)
        //     ->get();

        // return DB::table('users')
        //     ->where('created_at', '<', date('Y-m-d h:i:s'))
        //     ->orWhere('id', 1000)
        //     ->get();

        // return DB::table('users')
        //     ->where('created_at', '>', date('Y-m-d h:i:s'))
        //     ->orWhere(function ($q) {
        //         return $q->where('id', 1);
        //     })
        //     ->get();

        // return DB::table('users')
        //     ->where('name', 'admin')
        //     ->orWhere('id', 1)
        //     ->where('email', 'admin@gmail.com')
        //     ->get();
        /* select * from users where created_at > date('Y-m-d h:i:s') or id = 1 and email = admin@gmail.com */

        // return DB::table('users')
        //     ->where('name', 'admin')
        //     ->orWhere(function ($q) {
        //         return $q->where('email', 'admin@gmail.com')
        //             ->where('created_at', '>', date('Y-m-d h:i:s'));
        //     })
        //     ->get();
        /* select * from users where (name = 'admin') or (id = 1 and 'created_at', '>', date('Y-m-d h:i:s')) */

        // return DB::table('users')
        //     ->whereBetween('id', [2, 5])
        //     ->get();

        // return DB::table('users')
        //     ->whereNotBetween('id', [2, 10])
        //     ->get();

        // return DB::table('users')
        //     ->whereIn('name', ['test', 'admin', 'Willow Rau'])
        //     ->get();

        // return DB::table('users')
        //     ->whereNull('name')
        //     ->get();

        // return DB::table('users')
        //     ->whereNotNull('name')
        //     ->get();

        /* `whereRaw` allows you to pass an arbitrary string into a query, NOTE that Raw statements will be injected into the query as strings, so you should be extremely careful to avoid creating SQL injection vulnerabilities */
        // return DB::table('users')
        //     ->whereRaw('name = "admin"')
        //     ->get();

        /* When you pass the third parameter as `true` in `whereExists` method you'll feel as if you use `whereNotExists` */
        // return DB::table('users')
        //     ->whereExists(function ($q) {
        //         return $q->where('id', 'admin');
        //     }, 'or', true)
        //     ->get();

        // return DB::table('users')
        //     ->where('name', 'admin')
        //     ->distinct()
        //     ->get();

        /* the first parameter of the `when` method is a condition, and will execute the colsure if the condition was true else will skip this whole method. */
        // return DB::table('users')
        //     ->when(true, function ($q) {
        //         return $q->where('id', 1);
        //     })
        //     ->get();

        /* `unless` method is opposite of `when` */
        // return DB::table('users')
        //     ->unless(true, function ($q) {
        //         return $q->where('id', 1);
        //     })
        //     ->get();

        /* get only the first row in array */
        // return DB::table('users')
        //     ->where('email', 'like', '%.org%')
        //     ->first();

        /* give me first one in array or if you not found it fail(return 404 status code) */
        // return User::where('email', 'like', '%.test%')->firstOrFail();

        // return DB::table('users')
        //     ->whereId(12)
        //     ->update(['name' => 'Name Updated']);

        /* to use union the two tables must have the number of column */
        // return DB::table('posts')
        //     ->whereNotNull('body')
        //     ->select('id')
        //     ->addSelect('body');

        /* Laravel also supports querying JSON column types on databases that provide support for JSON column types */
        // return DB::table('users')
        //     ->whereJsonContains('options->languages', 'en')
        //     ->get();

        DB::table('users')
            ->whereJsonLength('options->languages', '>', 1)
            ->get();
    }

    public function daveIntoSQL()
    {
        // return DB::table('users')
        //     ->orderBy('name')
        //     ->get();

        // return DB::table('users')
        //     ->orderBy('name', 'desc')
        //     ->get();

        /* NOTE that you must get all the data then group them NOT the versa */
        // return DB::table('users')->get()->groupBy('name');

        /* also you can group your data, you filter results based on properties using `having` or `havingRow` methods NOTE that also you can NOT use `having` or `havingRaw` without group */
        // return DB::table('users')
        //     ->groupBy('id')
        //     ->having('created_at', '<', date('Y-m-d h:i:s'))
        //     ->get();

        /* NOTE that you can NOT use `skip` individually without `take` method */
        // return DB::table('users')
        //     ->skip(5)
        //     ->take(5)
        //     ->get();

        /* Alternatively, you may use the `limit` and `offset` methods. These methods are functionally equivalent to the `take` and `skip` methods, respectively */
        // return DB::table('users')
        //     ->offset(10)
        //     ->limit(5)
        //     ->get();

        /* `oldest` method means order by ascending */
        // return DB::table('users')
        //     ->oldest()
        //     ->get();

        /* `latest` method is the opposite of `oldest` */
        // return DB::table('users')
        //     ->latest()
        //     ->get();

        // return DB::table('users')
        //     ->inRandomOrder()
        //     ->get();

        /* `increment` specific column, also you can specify the number which you want to increment */
        // return DB::table('users')
        //     ->where('id', 16)
        //     ->increment('id', 2);

        // return DB::table('users')
        //     ->where('id', 18)
        //     ->decrement('id', 4);

        /* You may also specify additional columns to update during the operation */
        // return DB::table('users')->increment('id', 1, ['name' => 'John']);

        // return DB::table('users')->find(5);

        // return User::findOrFail(50);

        /* get the value of a specific column in first one */
        // return DB::table('users')
        //     ->orderBy('name')
        //     ->value('email');

        /* get the `min` value for a specific column */
        // return DB::table('users')
        //     ->min('id');

        /* get the `max` value for a specific column */
        // return DB::table('users')
        //     ->max('id');

        /* get the `average` value for a specific column */
        // return DB::table('users')
        //     ->average('id');

        /* get the `sum` value for a specific column */
        // return DB::table('users')
        //     ->sum('id');

        // return DB::table('users')
        //     ->select(DB::raw('name AS Name'))
        //     ->get();

        /* you can join two tables which satisfy a given condition. */
        // return DB::table('users')
        //     ->join('posts', 'users.id', '=', 'posts.user_id')
        //     ->get();

        // return DB::table('users')
        //     ->join('posts', function ($join) {
        //         $join->on('posts.user_id', '=', 'posts.user_id')
        //             ->orOn('users.id', '=', 'posts.body');
        //     })
        //     ->get();

        /* you can left join two tables which satisfy a given condition. */
        // return DB::table('users')
        //     ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
        //     ->get();

        /* you can right join two tables whcih satisfy a given condition. */
        // return DB::table('users')
        //     ->rightJoin('posts', 'users.id', '=', 'posts.user_id')
        //     ->get();

        return DB::table('comments')
            ->select('id', 'post_id')
            ->union(DB::table('posts')->where('id', 1)->get())
            ->get();
    }

    public function transactionsSQL()
    {
        /* user transactions to ensure that all or NOT all, BUT NOT some of a series of related quires are performed here if there is user with id equal `12` and `1000` the transaction will implemented successfully else NOT thing will implemented */
        // DB::transaction(function () {
        //     DB::table('users')
        //         ->where('id', 12)
        //         ->update(['name' => 'Mariam Ali']);

        //     DB::table('users')
        //         ->where('id', 1000)
        //         ->update(['name' => 'User not found']);
        // });

        // try {
        //     DB::beginTransaction();
        //     DB::table('users')
        //         ->where('id', 12)
        //         ->update(['name' => 'Nada Ali']);

        //     DB::table('users')
        //         ->where('id', 1000)
        //         ->delete();
        //     DB::commit();
        // } catch (\Exception $ex) {
        //     DB::rollBack();
        // }

        /* The `transaction` method accepts an optional second argument which defines the number of times a transaction should be retried when a deadlock occurs */
        DB::transaction(function () {
            DB::update('update users set lang=en');
            DB::delete('delete from posts');
        }, 5);
    }
}
