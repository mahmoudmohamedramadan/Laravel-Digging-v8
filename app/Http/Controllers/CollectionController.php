<?php

namespace App\Http\Controllers;

use App\Models\Department;

class CollectionController extends Controller
{
    /**
     * Use the most common collection methods.
     *
     * @return mixed
     */
    public function index()
    {
        $items = [
            ['name' => 'David Charleston', 'member' => 1, 'active' => 1],
            ['name' => 'Blain Charleston', 'member' => 0, 'active' => 0],
            ['name' => 'Megan Tarash', 'member' => 1, 'active' => 1],
            ['name' => 'Jonathan Phaedrus', 'member' => 1, 'active' => 1],
            ['name' => 'Paul Jackson', 'member' => 0, 'active' => 1]
        ];

        echo '<pre>';

        dump('reject');
        /* The `reject` method will return the reverse of the inner condition, which means this will return the users which them name not start with `M` */
        $collect_reject = collect($items)->reject(function ($item) {
            return str_starts_with($item['name'], 'M');
        });

        print_r($collect_reject);

        dump('filter');
        /* The `filter` method will return the results depending on the condition,  which means this will return the member where the `member` equals to 1 */
        $collect_filter = collect($items)->filter(function ($item) {
            return $item['member'] === 1;
        });

        print_r($collect_filter);

        dump('map');
        // The `map` method used to get something performed in each iterator
        $collect_map = collect($items)->map(function ($item) {
            $item_member = $item['member'] ? 'true' : 'false';
            $item_active = $item['active'] ? 'true' : 'false';
            return "Name: {$item['name']}, Member: {$item_member}, Active: {$item_active}";
        });

        print_r($collect_map);

        dump('tap');
        /* The `tap` method will get whole the collection in the parameter then you can loop over each item */
        $collect_tap = collect($items)
            ->tap(function ($collection) {
                return $collection->pluck('name');
            })
            ->where('member', 1)
            ->tap(function ($collection) {
                return "Name: {$collection->pluck('name')}, Member: true, Active: true";
            });

        print_r($collect_tap);

        /* NOTE: The `filter` and `map` iterate over the array but the `tap` iterate over the collection */

        dump('pipe');
        $collect_pipe = collect($items)
            ->pipe(function ($collection) {
                return $collection->pluck('name');
            });

        print_r($collect_pipe);

        /* NOTE: The difference between the `tap` and `pipe` is that despite of we ask to get the `name` only of all users using `pluck` in the `tap` we got all the data [name, member, active] again so, we can check if the user was a `member` or not but in case of `pipe` when we ask to get the `name` only using `pluck` we got the `name` only without rest of data [member, active] like `tap` */

        /* Here will reurn even numbers only then multiply each number in 10 and then finally get sum of all numbers */
        // return $collection
        //     ->filter(function ($num) {
        //         return $num % 2 === 0;
        //     })
        //     ->map(function ($num) {
        //         return $num * 10;
        //     })
        //     ->sum();

        // The `flip` method swaps the collection's keys with their corresponding values
        // $collection->flip()

        // The `flatten` method flattens a multi-dimensional collection into a single dimension
        // $collection->flatten()

        // array_map(), array_reduce()

        $departments = Department::get();

        /* The `reduceDepartmentCount` is a method inside the `DepartmentCollection` collection class that is assigned to the `Department` model */
        return $departments->reduceDepartmentCount();
    }
}
