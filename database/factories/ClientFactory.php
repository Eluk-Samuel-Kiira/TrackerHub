<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'created_by' => User::where('role', 'director' )->where('status', 'active')->get()->random()->id,
            'isActive' => 1,
        ];
    }

    public function inactive():static
    {
        return $this->state(fn(array $attributes) => ['isActive' => 0]);
    }
}
