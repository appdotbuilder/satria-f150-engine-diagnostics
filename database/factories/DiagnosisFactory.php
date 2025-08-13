<?php

namespace Database\Factories;

use App\Models\Diagnosis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnosis>
 */
class DiagnosisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minCost = $this->faker->randomFloat(2, 10, 500);
        $maxCost = $minCost + $this->faker->randomFloat(2, 50, 1000);

        return [
            'name' => $this->faker->words(random_int(2, 4), true),
            'description' => $this->faker->paragraph(random_int(3, 5)),
            'possible_causes' => $this->faker->paragraph(random_int(2, 4)),
            'recommended_actions' => $this->faker->paragraph(random_int(2, 4)),
            'severity' => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
            'estimated_cost_min' => $minCost,
            'estimated_cost_max' => $maxCost,
            'is_active' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that the diagnosis is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the diagnosis is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a diagnosis with a specific severity.
     */
    public function severity(string $severity): static
    {
        return $this->state(fn (array $attributes) => [
            'severity' => $severity,
        ]);
    }

    /**
     * Create a low severity diagnosis.
     */
    public function lowSeverity(): static
    {
        return $this->severity('low')->state(fn (array $attributes) => [
            'estimated_cost_min' => $this->faker->randomFloat(2, 10, 50),
            'estimated_cost_max' => $this->faker->randomFloat(2, 50, 150),
        ]);
    }

    /**
     * Create a critical severity diagnosis.
     */
    public function criticalSeverity(): static
    {
        return $this->severity('critical')->state(fn (array $attributes) => [
            'estimated_cost_min' => $this->faker->randomFloat(2, 300, 800),
            'estimated_cost_max' => $this->faker->randomFloat(2, 800, 2000),
        ]);
    }
}