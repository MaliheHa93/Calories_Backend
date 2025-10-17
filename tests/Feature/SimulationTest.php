<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Meal;

class SimulationTest extends TestCase
{
    /** @test */
    public function it_registers_a_meal_and_stores_in_database()
    {
        $payload = [
            'telegram_id' => 123456,
            'meal_name' => 'Lunch',
            'calories' => 500,
        ];

        $response = $this->postJson('/api/simulate/register-meal', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Meal registered successfully',
                     'meal' => [
                         'meal_name' => 'Lunch',
                         'calories' => 500,
                     ]
                 ]);

        // Check the DB
        $this->assertDatabaseHas('users', ['telegram_id' => 123456]);
        $this->assertDatabaseHas('meals', ['meal_name' => 'Lunch', 'calories' => 500]);
    }
    /** @test */
    public function it_returns_daily_summary_for_user()
    {
        $user = User::factory()->create([
            'telegram_id' => fake()->unique()->numberBetween(10000, 99999),
        ]);
        Meal::factory()->create([
            'user_id' => $user->id,
            'meal_name' => 'Breakfast',
            'calories' => 200,
            'created_at' => now(),
        ]);
        Meal::factory()->create([
            'user_id' => $user->id,
            'meal_name' => 'Lunch',
            'calories' => 500,
            'created_at' => now(),
        ]);

        $response = $this->getJson('/api/simulate/daily-summary?telegram_id=98765');

        $response->assertStatus(200)
                ->assertJson([
                    'total_calories' => 500,
                ]);
    }

}
