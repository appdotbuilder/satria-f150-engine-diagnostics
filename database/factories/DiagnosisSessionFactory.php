<?php

namespace Database\Factories;

use App\Models\DiagnosisSession;
use App\Models\Symptom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiagnosisSession>
 */
class DiagnosisSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random symptom IDs for the session
        $symptomCount = random_int(1, 6);
        $symptoms = Symptom::inRandomOrder()->take($symptomCount)->pluck('id')->toArray();

        return [
            'session_id' => DiagnosisSession::generateSessionId(),
            'selected_symptoms' => $symptoms,
            'diagnosis_results' => null,
            'diagnosed_at' => null,
            'motorcycle_model' => 'Suzuki Satria F150',
            'motorcycle_year' => $this->faker->numberBetween(2010, 2024),
            'mileage' => $this->faker->numberBetween(1000, 100000),
        ];
    }

    /**
     * Indicate that the session has been diagnosed.
     */
    public function diagnosed(): static
    {
        return $this->state(fn (array $attributes) => [
            'diagnosis_results' => [
                [
                    'diagnosis_id' => 1,
                    'confidence' => $this->faker->numberBetween(70, 95),
                    'match_percentage' => $this->faker->numberBetween(80, 100),
                ],
            ],
            'diagnosed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create a session with specific symptoms.
     */
    public function withSymptoms(array $symptomIds): static
    {
        return $this->state(fn (array $attributes) => [
            'selected_symptoms' => $symptomIds,
        ]);
    }

    /**
     * Create a session for a specific motorcycle year.
     */
    public function motorcycleYear(int $year): static
    {
        return $this->state(fn (array $attributes) => [
            'motorcycle_year' => $year,
        ]);
    }
}