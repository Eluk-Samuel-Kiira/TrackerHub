<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->currencyCode(),
            'created_by' => User::where('role', 'director' )->where('status', 'active')->get()->random()->id,
            'isActive' => 1,
        ];
    }

    public function inactive():static
    {
        return $this->state(fn(array $attributes) => ['isActive' => 0]);
    }
}
