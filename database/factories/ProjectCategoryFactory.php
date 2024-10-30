<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectCategory>
 */
class ProjectCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word() .' Category',
            'isActive' => 1,
            'created_by' => User::where('role', 'director' )->where('status', 'active')->get()->random()->id,
        ];
    }
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => ['isActive' => 0]);
    }
}
