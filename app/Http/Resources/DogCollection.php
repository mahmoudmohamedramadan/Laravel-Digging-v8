<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DogCollection extends ResourceCollection
{
    /* NOTE that when you write >> `php artisan make:resource DogCollection` the type of this class will be a collection because the end of the resource name ends with `Collection` or we can do this `php artisan make:resource Dog --collection` */

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /* NOTE that when we call `collection` property will loop over each dog through the resource that we have created,
        this means when we call `collection` property, the `DogResource` will be called with the same count of dog's table records that means if you do NOT have the `DogResource` an error will be triggered */

        /* IMPORTANT NOTE: the `DogCollection` always search for `DogResource` if this file NOT found an error will be triggered; else will be fine even if you pass to the `collection` method any model like `Post` and in this case the colection will use that `Post` model for looping */

        return [
            'dogs' => $this->resource,
            'request' => $request,
            'links' => [
                'self' => route('dogs.index'),
            ],
        ];
    }
}
