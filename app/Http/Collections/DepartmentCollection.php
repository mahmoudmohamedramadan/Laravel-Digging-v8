<?php

namespace App\Http\Collections;

use Illuminate\Database\Eloquent\Collection;

class DepartmentCollection extends Collection
{
    /**
     * Reduce the department count.
     *
     * @return mixed
     */
    public function reduceDepartmentCount()
    {
        /* The `$carry` and `$item` allow you to show all items in the collection, whereas, the `$carry` used to carry the result of the last iteration to the next iteration */
        /* For more info: https://riptutorial.com/laravel/example/12397/using-reduce--#:~:text=Laravel%20Using%20reduce()&text=The%20reduce%20method%20reduces%20the,result%20to%20the%20next%20iteration */
        return $this->reduce(function ($carry, $item) {
            return  "{$item['name']} >> {$carry}";
        });
    }
}
