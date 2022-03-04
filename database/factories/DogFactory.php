<?php

namespace Database\Factories;

use App\Models\Dog;
use Illuminate\Database\Eloquent\Factories\Factory;

class DogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function() {
                return \App\Models\User::get()->random();
            },
            'name' => $this->faker->name,
            'tame' => $this->faker->numberBetween(0, 1),
        ];
    }
}
