<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // NOTE: `$this->resource->name` is equal to `$this->name`

        return [
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'comments' => $this->resource->comments,     // you can call the relationship
            'posts' => $this->when($this->posts->first()->id == 1, $this->posts->first()),
            // 'posts' => $this->whenAppended($this->posts->first()->id == 1, $this->posts->first()),
            // 'posts' => $this->whenLoaded($this->posts->first()->id == 1, $this->posts->first()),
        ];
    }
}
