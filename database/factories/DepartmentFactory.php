<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElements(['IT', 'CS', 'IS', 'Agricultural Marketing Service', 'Farm Service Agency', 'Food and Nutrition Service']),
            'departmentable_type' => $this->faker->randomElement(['\App\User'], ['\App\Admin']),
            'departmentable_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
