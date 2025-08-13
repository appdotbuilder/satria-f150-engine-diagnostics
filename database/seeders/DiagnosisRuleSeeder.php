<?php

namespace Database\Seeders;

use App\Models\DiagnosisRule;
use Illuminate\Database\Seeder;

class DiagnosisRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            // Spark Plug Failure Rules
            [
                'diagnosis_id' => 1,
                'required_symptoms' => [1, 5], // Engine Won't Start, Hard Starting
                'confidence_score' => 85,
                'priority' => 8,
                'rule_description' => 'Starting problems often indicate spark plug issues',
            ],
            [
                'diagnosis_id' => 1,
                'required_symptoms' => [7, 10], // Engine Misfiring, Clicking Sounds
                'confidence_score' => 80,
                'priority' => 7,
                'rule_description' => 'Misfiring with clicking sounds suggests spark plug problems',
            ],
            
            // Carburetor Problems Rules
            [
                'diagnosis_id' => 2,
                'required_symptoms' => [2, 3, 6], // Rough Idling, Loss of Power, Poor Fuel Economy
                'confidence_score' => 90,
                'priority' => 9,
                'rule_description' => 'Classic carburetor symptoms: rough idle, power loss, poor economy',
            ],
            [
                'diagnosis_id' => 2,
                'required_symptoms' => [4, 14], // Engine Stalling, Black Smoke from Exhaust
                'confidence_score' => 85,
                'priority' => 8,
                'rule_description' => 'Stalling with black smoke indicates rich fuel mixture',
            ],
            [
                'diagnosis_id' => 2,
                'required_symptoms' => [20, 23], // Fuel Smell, Carburetor Flooding
                'confidence_score' => 95,
                'priority' => 10,
                'rule_description' => 'Fuel smell and flooding directly indicate carburetor issues',
            ],
            
            // Piston Ring Wear Rules
            [
                'diagnosis_id' => 3,
                'required_symptoms' => [15, 3], // Blue Smoke from Exhaust, Loss of Power
                'confidence_score' => 90,
                'priority' => 9,
                'rule_description' => 'Blue smoke indicates oil burning from worn rings',
            ],
            [
                'diagnosis_id' => 3,
                'required_symptoms' => [16, 6], // Oil Leaks, Poor Fuel Economy
                'confidence_score' => 75,
                'priority' => 6,
                'rule_description' => 'Oil consumption and economy issues suggest ring wear',
            ],
            
            // Valve Problems Rules
            [
                'diagnosis_id' => 4,
                'required_symptoms' => [10, 3, 2], // Clicking Sounds, Loss of Power, Rough Idling
                'confidence_score' => 85,
                'priority' => 8,
                'rule_description' => 'Valve noise with performance issues indicates valve problems',
            ],
            [
                'diagnosis_id' => 4,
                'required_symptoms' => [1, 18], // Engine Won't Start, Engine Overheating
                'confidence_score' => 70,
                'priority' => 6,
                'rule_description' => 'Starting issues with overheating may indicate valve problems',
            ],
            
            // Head Gasket Failure Rules
            [
                'diagnosis_id' => 5,
                'required_symptoms' => [13, 17, 18], // White Smoke from Exhaust, Coolant Leaks, Engine Overheating
                'confidence_score' => 95,
                'priority' => 10,
                'rule_description' => 'Classic head gasket failure symptoms',
            ],
            [
                'diagnosis_id' => 5,
                'required_symptoms' => [16, 18], // Oil Leaks, Engine Overheating
                'confidence_score' => 80,
                'priority' => 7,
                'rule_description' => 'Oil and coolant mixing indicates head gasket failure',
            ],
            
            // Air Filter Blockage Rules
            [
                'diagnosis_id' => 6,
                'required_symptoms' => [3, 6], // Loss of Power, Poor Fuel Economy
                'confidence_score' => 70,
                'priority' => 5,
                'rule_description' => 'Power loss and poor economy may indicate air filter blockage',
            ],
            [
                'diagnosis_id' => 6,
                'required_symptoms' => [14, 6], // Black Smoke from Exhaust, Poor Fuel Economy
                'confidence_score' => 75,
                'priority' => 6,
                'rule_description' => 'Rich mixture symptoms from restricted airflow',
            ],
            
            // Fuel System Contamination Rules
            [
                'diagnosis_id' => 7,
                'required_symptoms' => [4, 7, 20], // Engine Stalling, Engine Misfiring, Fuel Smell
                'confidence_score' => 85,
                'priority' => 8,
                'rule_description' => 'Contaminated fuel causes stalling and misfiring',
            ],
            [
                'diagnosis_id' => 7,
                'required_symptoms' => [1, 21], // Engine Won't Start, Fuel Leaks
                'confidence_score' => 80,
                'priority' => 7,
                'rule_description' => 'Fuel system problems prevent starting',
            ],
            
            // Ignition System Failure Rules
            [
                'diagnosis_id' => 8,
                'required_symptoms' => [1, 7, 19], // Engine Won't Start, Engine Misfiring, Check Engine Light
                'confidence_score' => 90,
                'priority' => 9,
                'rule_description' => 'Ignition system failure causes starting and running problems',
            ],
            [
                'diagnosis_id' => 8,
                'required_symptoms' => [5, 20], // Hard Starting, Battery Issues
                'confidence_score' => 75,
                'priority' => 6,
                'rule_description' => 'Electrical problems affect ignition system',
            ],
            
            // Engine Bearing Wear Rules
            [
                'diagnosis_id' => 9,
                'required_symptoms' => [8, 9, 11], // Knocking Sounds, Grinding Noise, Rattling Noise
                'confidence_score' => 95,
                'priority' => 10,
                'rule_description' => 'Multiple metallic noises indicate bearing wear',
            ],
            [
                'diagnosis_id' => 9,
                'required_symptoms' => [16, 26], // Oil Leaks, Excessive Vibration
                'confidence_score' => 80,
                'priority' => 7,
                'rule_description' => 'Oil loss and vibration suggest bearing problems',
            ],
            
            // Cooling System Problems Rules
            [
                'diagnosis_id' => 10,
                'required_symptoms' => [18, 17], // Engine Overheating, Coolant Leaks
                'confidence_score' => 90,
                'priority' => 9,
                'rule_description' => 'Overheating with coolant loss indicates cooling system failure',
            ],
            [
                'diagnosis_id' => 10,
                'required_symptoms' => [24, 18], // Engine Running Hot, Engine Overheating
                'confidence_score' => 85,
                'priority' => 8,
                'rule_description' => 'High operating temperatures indicate cooling problems',
            ],
            
            // Exhaust System Blockage Rules
            [
                'diagnosis_id' => 11,
                'required_symptoms' => [3, 12], // Loss of Power, Loud Exhaust
                'confidence_score' => 75,
                'priority' => 6,
                'rule_description' => 'Power loss with exhaust noise suggests blockage',
            ],
            [
                'diagnosis_id' => 11,
                'required_symptoms' => [12, 26], // Loud Exhaust, Excessive Vibration
                'confidence_score' => 70,
                'priority' => 5,
                'rule_description' => 'Exhaust system damage causes noise and vibration',
            ],
            
            // Cylinder Compression Loss Rules
            [
                'diagnosis_id' => 12,
                'required_symptoms' => [1, 3, 5], // Engine Won't Start, Loss of Power, Hard Starting
                'confidence_score' => 85,
                'priority' => 8,
                'rule_description' => 'Starting and power problems indicate compression loss',
            ],
            [
                'diagnosis_id' => 12,
                'required_symptoms' => [15, 13], // Blue Smoke from Exhaust, White Smoke from Exhaust
                'confidence_score' => 80,
                'priority' => 7,
                'rule_description' => 'Multiple smoke colors suggest internal engine damage',
            ],
        ];

        foreach ($rules as $rule) {
            DiagnosisRule::create($rule);
        }
    }
}