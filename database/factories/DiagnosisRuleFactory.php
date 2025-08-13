<?php

namespace Database\Factories;

use App\Models\Diagnosis;
use App\Models\DiagnosisRule;
use App\Models\Symptom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiagnosisRule>
 */
class DiagnosisRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random symptom IDs for the rule
        $symptomCount = random_int(1, 4);
        $symptoms = Symptom::inRandomOrder()->take($symptomCount)->pluck('id')->toArray();

        return [
            'diagnosis_id' => Diagnosis::factory(),
            'required_symptoms' => $symptoms,
            'confidence_score' => $this->faker->numberBetween(60, 100),
            'priority' => $this->faker->numberBetween(1, 10),
            'rule_description' => $this->faker->sentence(random_int(8, 15)),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that the rule is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the rule is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a high confidence rule.
     */
    public function highConfidence(): static
    {
        return $this->state(fn (array $attributes) => [
            'confidence_score' => $this->faker->numberBetween(85, 100),
            'priority' => $this->faker->numberBetween(7, 10),
        ]);
    }

    /**
     * Create a rule with specific symptoms.
     */
    public function withSymptoms(array $symptomIds): static
    {
        return $this->state(fn (array $attributes) => [
            'required_symptoms' => $symptomIds,
        ]);
    }
}