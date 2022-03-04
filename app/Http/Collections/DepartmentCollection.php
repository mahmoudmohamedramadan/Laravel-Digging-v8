<?php

namespace App\Http\Collections;

use Illuminate\Database\Eloquent\Collection;

class DepartmentCollection extends Collection
{
    public function reduceDepartmentCount()
    {
        /* If you want to return all collection type... return `$this`
         using `$carry` and `$item` allows you to show all items in the collection, `$carry` used to carry the result of the last iteration...for more info...https://riptutorial.com/laravel/example/12397/using-reduce--#:~:text=Laravel%20Using%20reduce()&text=The%20reduce%20method%20reduces%20the,result%20to%20the%20next%20iteration. */
        return $this->reduce(function ($carry, $item) {
            return  $item['name'] .' >> '.$carry;
        });
    }
}
