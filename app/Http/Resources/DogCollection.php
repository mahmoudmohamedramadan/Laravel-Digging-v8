<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DogCollection extends ResourceCollection
{
    /* NOTE: When you write `php artisan make:resource DogCollection` the type of this class will be a collection because the end of the resource name ends with `Collection` or we can do this `php artisan make:resource Dog --collection` */

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /* NOTE: When we call the `collection` property, the `DogResource` will be called with the data of the `dogs` table, otherwise, the given dog's collection will be shown */
        return [
            'dogs' => $this->resource, // Equals to: $this->collection
            'request' => $request,
            'index' => route('dogs.index'),
        ];
    }
}
