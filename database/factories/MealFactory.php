<?php

namespace Database\Factories;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    protected $model = Meal::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'meal_name' => $this->faker->randomElement(['Breakfast', 'Lunch', 'Dinner']),
            'calories' => $this->faker->numberBetween(100, 800),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
