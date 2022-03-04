<?php

namespace Database\Factories;

use App\Models\{
    User,
    Product,
};
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first(),
            'name' => $this->faker->randomElements(['Milk', 'Corn', 'Water', 'Compouter', 'Tablet', 'Laptop', 'Sportswear', 'Footwear', 'Accessories', 'Nike', 'Puma', 'Beta', 'GAS', 'Infomercial Posters', 'Formative Posters', 'Show Posters', 'Show Posters']),
            'price' => $this->faker->numberBetween(100, 1000)
        ];
    }
}
