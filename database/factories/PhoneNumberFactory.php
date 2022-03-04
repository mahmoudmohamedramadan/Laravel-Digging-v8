<?php

namespace Database\Factories;

use App\Models\{
    User,
    PhoneNumber,
};
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneNumberFactory extends Factory
{
 /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PhoneNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function() {
                return User::get()->random();
            },
            'phone_number' => $this->faker->phoneNumber,
        ];
    }

}

