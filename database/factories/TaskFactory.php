<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $team = Team::inRandomOrder()->first();
        return [
            'title' => fake()->text(),
            'body' => fake()->text(),
            'status' => 0,
            'team_id' => $team->id,
        ];
    }
}
