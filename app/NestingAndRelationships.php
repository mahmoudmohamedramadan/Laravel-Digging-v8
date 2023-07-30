<?php

namespace App;

class NestingAndRelationships
{
    protected $user, $includes;

    public function __construct($user, $includes = [])
    {
        $this->user = $user;
        $this->includes = $includes;
    }

    public function toArray()
    {
        $append = [];

        if (!in_array('comments', $append)) {
            $append['comments'] = $this->user->comments->map(function ($comment) {
                return $comment->toArray();
            });
        }

        return array_merge([
            'id' => $this->user->id,
            'name' => sprintf('%s %s', $this->user->name, $this->user->email),
            'commentsCount' => $this->user->comments->count(),
            'comments' => $append,
        ], $append);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
