<?php

namespace Database\Factories;

use App\Models\{
    User,
    Post,
    Comment,
};
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => Post::inRandomOrder()->first(),
            'user_id' => User::inRandomOrder()->first(),
            'body' => $this->faker->sentence(),
        ];
    }

    /* The `state` manipulation methods allows you to define discrete modifications that can be applied to your model factories in any combination, for example here the `body` key in the below method will override the same key that exists in `defination` method. You can use this function later like so : `Comment::factory(10)->commentVIP()->create();` */
    public function commentVIP()
    {
        return $this->state(function (array $attributes) {
            return [
                'body' => $this->faker->sentence(),
            ];
        });
    }
}
