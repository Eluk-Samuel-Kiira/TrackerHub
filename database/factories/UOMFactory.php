<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\UOM;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UOM>
 */
class UOMFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word, 
            'created_by' => User::where('role', 'director' )->where('status', 'active')->get()->random()->id,
            'isActive' => $this->faker->randomElement([0, 1]), // Randomly assigns 0 or 1
        ];
    }
}
