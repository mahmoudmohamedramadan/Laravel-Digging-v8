<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DogResource extends JsonResource
{
    /* In the past, one of chanllengs we'd run into when developing APIs in Laravel was how to transform our data. The simplest APIs can just return Eloquent objects as JSON, but very quickly the needs of most APIs outgrow that structure.
    How should we convert our Eloquent results into the right format? What if we want to embed other resources

    So say hello to Eloquent API resourcse, you can do so with this command >> php artisan make:resource ResourceName */

    // NOTE: This resource is attached with `Dog` Model, becuase this class starts with `Dog`

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // NOTE: `$this` refers to the Eloquent `Dog` object

        return [
            'id' => $this->id,
            'name' => $this->name,
            'tame' => $this->tame,
            'resource' => true,
        ];
    }
}
