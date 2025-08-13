<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symptoms = [
            // Engine Performance Symptoms
            [
                'name' => 'Engine Won\'t Start',
                'description' => 'Engine cranks but fails to start or doesn\'t crank at all',
                'category' => 'performance',
            ],
            [
                'name' => 'Rough Idling',
                'description' => 'Engine runs roughly or irregularly when idling',
                'category' => 'performance',
            ],
            [
                'name' => 'Loss of Power',
                'description' => 'Noticeable decrease in engine power and acceleration',
                'category' => 'performance',
            ],
            [
                'name' => 'Engine Stalling',
                'description' => 'Engine suddenly stops running during operation',
                'category' => 'performance',
            ],
            [
                'name' => 'Hard Starting',
                'description' => 'Engine is difficult to start, requires multiple attempts',
                'category' => 'performance',
            ],
            [
                'name' => 'Poor Fuel Economy',
                'description' => 'Significant increase in fuel consumption',
                'category' => 'performance',
            ],
            [
                'name' => 'Engine Misfiring',
                'description' => 'Engine runs unevenly, jerky acceleration, or backfiring',
                'category' => 'performance',
            ],
            
            // Sound-related Symptoms
            [
                'name' => 'Knocking Sounds',
                'description' => 'Metallic knocking or pinging sounds from engine',
                'category' => 'sound',
            ],
            [
                'name' => 'Grinding Noise',
                'description' => 'Harsh grinding noise from engine area',
                'category' => 'sound',
            ],
            [
                'name' => 'Clicking Sounds',
                'description' => 'Rapid clicking or ticking sounds from engine',
                'category' => 'sound',
            ],
            [
                'name' => 'Rattling Noise',
                'description' => 'Rattling or shaking sounds during engine operation',
                'category' => 'sound',
            ],
            [
                'name' => 'Loud Exhaust',
                'description' => 'Unusually loud or abnormal exhaust sounds',
                'category' => 'sound',
            ],
            
            // Visual Symptoms
            [
                'name' => 'White Smoke from Exhaust',
                'description' => 'White or light gray smoke coming from exhaust pipe',
                'category' => 'visual',
            ],
            [
                'name' => 'Black Smoke from Exhaust',
                'description' => 'Dark black smoke coming from exhaust pipe',
                'category' => 'visual',
            ],
            [
                'name' => 'Blue Smoke from Exhaust',
                'description' => 'Blue-tinted smoke coming from exhaust pipe',
                'category' => 'visual',
            ],
            [
                'name' => 'Oil Leaks',
                'description' => 'Visible oil leaks under or around the engine',
                'category' => 'visual',
            ],
            [
                'name' => 'Coolant Leaks',
                'description' => 'Coolant puddles or visible coolant leaks',
                'category' => 'visual',
            ],
            [
                'name' => 'Engine Overheating',
                'description' => 'Engine temperature gauge showing high temperature',
                'category' => 'visual',
            ],
            
            // Electrical Symptoms
            [
                'name' => 'Check Engine Light',
                'description' => 'Check engine warning light is illuminated',
                'category' => 'electrical',
            ],
            [
                'name' => 'Battery Issues',
                'description' => 'Battery not charging or electrical problems',
                'category' => 'electrical',
            ],
            [
                'name' => 'Starter Problems',
                'description' => 'Electric starter not working properly',
                'category' => 'electrical',
            ],
            
            // Fuel System Symptoms
            [
                'name' => 'Fuel Smell',
                'description' => 'Strong gasoline odor around the motorcycle',
                'category' => 'fuel',
            ],
            [
                'name' => 'Fuel Leaks',
                'description' => 'Visible fuel leaks from tank, lines, or carburetor',
                'category' => 'fuel',
            ],
            [
                'name' => 'Carburetor Flooding',
                'description' => 'Excess fuel in carburetor causing flooding',
                'category' => 'fuel',
            ],
            
            // Temperature Symptoms
            [
                'name' => 'Engine Running Hot',
                'description' => 'Engine temperature higher than normal operating range',
                'category' => 'temperature',
            ],
            [
                'name' => 'Engine Running Cold',
                'description' => 'Engine not reaching normal operating temperature',
                'category' => 'temperature',
            ],
            
            // Vibration Symptoms
            [
                'name' => 'Excessive Vibration',
                'description' => 'Abnormal vibrations throughout the motorcycle',
                'category' => 'vibration',
            ],
        ];

        foreach ($symptoms as $symptom) {
            Symptom::create($symptom);
        }
    }
}