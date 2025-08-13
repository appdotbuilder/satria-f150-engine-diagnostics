<?php

namespace Database\Factories;

use App\Models\Symptom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Symptom>
 */
class SymptomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(random_int(2, 4), true),
            'description' => $this->faker->sentence(random_int(8, 15)),
            'category' => $this->faker->randomElement([
                'performance', 'sound', 'visual', 'electrical', 'fuel', 'temperature', 'vibration'
            ]),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that the symptom is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the symptom is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a symptom for a specific category.
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }
}