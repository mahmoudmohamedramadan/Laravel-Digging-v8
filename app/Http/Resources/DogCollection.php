<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DogCollection extends ResourceCollection
{
    /* NOTE: when you write `php artisan make:resource DogCollection` the type of this class will be a collection because the end of the resource name ends with `Collection` or we can do this `php artisan make:resource Dog --collection` */

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /* NOTE: when we call `collection` property, the `DogResource` will be called with the data of `dogs` table, otherwise the given dogs collection will be shown */

        return [
            'dogs' => $this->resource, // equals to: $this->collection
            'request' => $request,
            'index' => route('dogs.index'),
        ];
    }
}
