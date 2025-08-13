<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use Illuminate\Database\Seeder;

class DiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diagnoses = [
            [
                'name' => 'Spark Plug Failure',
                'description' => 'One or more spark plugs are fouled, worn out, or damaged, preventing proper ignition.',
                'possible_causes' => 'Carbon buildup, electrode wear, incorrect gap, oil fouling, or manufacturing defect.',
                'recommended_actions' => 'Replace spark plug(s), check ignition system, clean combustion chamber if necessary.',
                'severity' => 'low',
                'estimated_cost_min' => 15.00,
                'estimated_cost_max' => 50.00,
            ],
            [
                'name' => 'Carburetor Problems',
                'description' => 'Carburetor is clogged, misadjusted, or has worn components affecting fuel-air mixture.',
                'possible_causes' => 'Dirty fuel, clogged jets, float issues, worn needle valve, or incorrect adjustment.',
                'recommended_actions' => 'Clean carburetor thoroughly, replace worn parts, adjust fuel-air mixture, use quality fuel.',
                'severity' => 'medium',
                'estimated_cost_min' => 80.00,
                'estimated_cost_max' => 200.00,
            ],
            [
                'name' => 'Piston Ring Wear',
                'description' => 'Piston rings are worn, causing loss of compression and oil burning.',
                'possible_causes' => 'Normal wear, poor maintenance, contaminated oil, or engine overheating.',
                'recommended_actions' => 'Replace piston rings, check cylinder condition, perform compression test.',
                'severity' => 'high',
                'estimated_cost_min' => 300.00,
                'estimated_cost_max' => 600.00,
            ],
            [
                'name' => 'Valve Problems',
                'description' => 'Intake or exhaust valves are stuck, burned, or improperly adjusted.',
                'possible_causes' => 'Carbon buildup, improper valve clearance, bent valves, or valve seat wear.',
                'recommended_actions' => 'Adjust valve clearance, clean or replace valves, check valve seats.',
                'severity' => 'high',
                'estimated_cost_min' => 200.00,
                'estimated_cost_max' => 500.00,
            ],
            [
                'name' => 'Head Gasket Failure',
                'description' => 'Head gasket is blown or damaged, causing compression loss and coolant leaks.',
                'possible_causes' => 'Engine overheating, improper torque, age-related deterioration.',
                'recommended_actions' => 'Replace head gasket, check cylinder head for warping, address overheating cause.',
                'severity' => 'critical',
                'estimated_cost_min' => 400.00,
                'estimated_cost_max' => 800.00,
            ],
            [
                'name' => 'Air Filter Blockage',
                'description' => 'Air filter is severely clogged, restricting airflow to the engine.',
                'possible_causes' => 'Dust accumulation, oil contamination, or damaged filter element.',
                'recommended_actions' => 'Replace air filter, check air intake system, clean air box.',
                'severity' => 'low',
                'estimated_cost_min' => 20.00,
                'estimated_cost_max' => 40.00,
            ],
            [
                'name' => 'Fuel System Contamination',
                'description' => 'Fuel system contains water, dirt, or other contaminants affecting engine operation.',
                'possible_causes' => 'Poor quality fuel, water in tank, dirty fuel lines, or contaminated fuel filter.',
                'recommended_actions' => 'Drain fuel tank, replace fuel filter, clean fuel lines, use quality fuel.',
                'severity' => 'medium',
                'estimated_cost_min' => 60.00,
                'estimated_cost_max' => 150.00,
            ],
            [
                'name' => 'Ignition System Failure',
                'description' => 'Ignition coil, CDI unit, or other ignition components are malfunctioning.',
                'possible_causes' => 'Electronic component failure, loose connections, or moisture damage.',
                'recommended_actions' => 'Test ignition system, replace faulty components, check all connections.',
                'severity' => 'medium',
                'estimated_cost_min' => 100.00,
                'estimated_cost_max' => 300.00,
            ],
            [
                'name' => 'Engine Bearing Wear',
                'description' => 'Crankshaft or connecting rod bearings are worn or damaged.',
                'possible_causes' => 'Poor lubrication, contaminated oil, overheating, or normal wear.',
                'recommended_actions' => 'Replace bearings, check crankshaft condition, ensure proper lubrication.',
                'severity' => 'critical',
                'estimated_cost_min' => 500.00,
                'estimated_cost_max' => 1200.00,
            ],
            [
                'name' => 'Cooling System Problems',
                'description' => 'Cooling system is not functioning properly, causing engine overheating.',
                'possible_causes' => 'Low coolant, radiator blockage, faulty thermostat, or water pump failure.',
                'recommended_actions' => 'Check coolant level, flush cooling system, replace thermostat if needed.',
                'severity' => 'high',
                'estimated_cost_min' => 80.00,
                'estimated_cost_max' => 250.00,
            ],
            [
                'name' => 'Exhaust System Blockage',
                'description' => 'Exhaust pipe or muffler is blocked, restricting exhaust flow.',
                'possible_causes' => 'Carbon buildup, debris, damaged baffle, or collapsed exhaust pipe.',
                'recommended_actions' => 'Clean or replace exhaust components, check for internal damage.',
                'severity' => 'medium',
                'estimated_cost_min' => 50.00,
                'estimated_cost_max' => 200.00,
            ],
            [
                'name' => 'Cylinder Compression Loss',
                'description' => 'Engine cylinder has lost compression due to internal damage.',
                'possible_causes' => 'Worn piston rings, damaged cylinder, valve problems, or head gasket failure.',
                'recommended_actions' => 'Perform compression test, identify source of compression loss, repair accordingly.',
                'severity' => 'high',
                'estimated_cost_min' => 250.00,
                'estimated_cost_max' => 700.00,
            ],
        ];

        foreach ($diagnoses as $diagnosis) {
            Diagnosis::create($diagnosis);
        }
    }
}