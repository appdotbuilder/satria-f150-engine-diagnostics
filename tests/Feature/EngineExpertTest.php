<?php

namespace Tests\Feature;

use App\Models\Diagnosis;
use App\Models\DiagnosisRule;
use App\Models\DiagnosisSession;
use App\Models\Symptom;
use App\Services\EngineExpertService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EngineExpertTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed the database with test data
        $this->artisan('db:seed');
    }

    public function test_homepage_displays_expert_system()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
                ->has('symptoms')
                ->has('categories')
        );
    }

    public function test_can_get_available_symptoms()
    {
        $service = new EngineExpertService();
        $symptoms = $service->getAvailableSymptoms();

        $this->assertIsArray($symptoms);
        $this->assertNotEmpty($symptoms);
        
        // Check that symptoms are grouped by category
        foreach ($symptoms as $category => $categorySymptoms) {
            $this->assertIsString($category);
            $this->assertIsArray($categorySymptoms);
            
            foreach ($categorySymptoms as $symptom) {
                $this->assertArrayHasKey('id', $symptom);
                $this->assertArrayHasKey('name', $symptom);
                $this->assertArrayHasKey('description', $symptom);
                $this->assertArrayHasKey('category', $symptom);
            }
        }
    }

    public function test_can_perform_diagnosis_with_symptoms()
    {
        // Get some symptoms to test with
        $symptoms = Symptom::active()->take(3)->pluck('id')->toArray();
        
        $response = $this->post('/', [
            'symptoms' => $symptoms,
            'motorcycle_model' => 'Suzuki Satria F150',
            'motorcycle_year' => 2020,
            'mileage' => 15000,
        ]);

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
                ->has('symptoms')
                ->has('categories')
                ->has('diagnosis')
                ->has('flash.success')
        );
    }

    public function test_diagnosis_returns_results_with_confidence_scores()
    {
        $service = new EngineExpertService();
        
        // Create a specific test case
        $symptom1 = Symptom::factory()->create(['name' => 'Engine Won\'t Start']);
        $symptom2 = Symptom::factory()->create(['name' => 'Hard Starting']);
        
        $diagnosis = Diagnosis::factory()->create(['name' => 'Spark Plug Failure']);
        
        DiagnosisRule::factory()->create([
            'diagnosis_id' => $diagnosis->id,
            'required_symptoms' => [$symptom1->id, $symptom2->id],
            'confidence_score' => 90,
            'priority' => 8,
        ]);
        
        $results = $service->diagnose([$symptom1->id, $symptom2->id]);
        
        $this->assertArrayHasKey('diagnosis_results', $results);
        $this->assertNotEmpty($results['diagnosis_results']);
        
        $firstResult = $results['diagnosis_results'][0];
        $this->assertArrayHasKey('confidence', $firstResult);
        $this->assertArrayHasKey('match_percentage', $firstResult);
        $this->assertGreaterThan(0, $firstResult['confidence']);
    }

    public function test_validation_requires_symptoms()
    {
        $response = $this->post('/', [
            'symptoms' => [],
        ]);

        $response->assertSessionHasErrors(['symptoms']);
    }

    public function test_validation_accepts_optional_motorcycle_info()
    {
        $symptoms = Symptom::active()->take(2)->pluck('id')->toArray();
        
        $response = $this->post('/', [
            'symptoms' => $symptoms,
            'motorcycle_year' => 2015,
            'mileage' => 25000,
        ]);

        $response->assertStatus(200);
    }

    public function test_diagnosis_session_is_created_and_stored()
    {
        $symptoms = Symptom::active()->take(2)->pluck('id')->toArray();
        
        $this->post('/', [
            'symptoms' => $symptoms,
            'motorcycle_model' => 'Suzuki Satria F150',
        ]);

        $this->assertDatabaseHas('diagnosis_sessions', [
            'motorcycle_model' => 'Suzuki Satria F150',
        ]);

        $session = DiagnosisSession::first();
        $this->assertEquals($symptoms, $session->selected_symptoms);
        $this->assertNotNull($session->diagnosed_at);
    }

    public function test_forward_chaining_reasoning_works()
    {
        $service = new EngineExpertService();
        
        // Create symptoms
        $symptom1 = Symptom::factory()->create();
        $symptom2 = Symptom::factory()->create();
        $symptom3 = Symptom::factory()->create();
        
        // Create diagnoses with different priorities
        $highPriorityDiagnosis = Diagnosis::factory()->create(['name' => 'Critical Issue']);
        $lowPriorityDiagnosis = Diagnosis::factory()->create(['name' => 'Minor Issue']);
        
        // Create rules with different priorities
        DiagnosisRule::factory()->create([
            'diagnosis_id' => $highPriorityDiagnosis->id,
            'required_symptoms' => [$symptom1->id, $symptom2->id],
            'confidence_score' => 95,
            'priority' => 10,
        ]);
        
        DiagnosisRule::factory()->create([
            'diagnosis_id' => $lowPriorityDiagnosis->id,
            'required_symptoms' => [$symptom1->id],
            'confidence_score' => 70,
            'priority' => 5,
        ]);
        
        $results = $service->diagnose([$symptom1->id, $symptom2->id, $symptom3->id]);
        
        // High priority diagnosis should be first
        $this->assertEquals('Critical Issue', $results['diagnosis_results'][0]['name']);
        
        // Should have confidence scores
        $this->assertGreaterThan(90, $results['diagnosis_results'][0]['confidence']);
    }

    public function test_can_filter_symptoms_by_category()
    {
        // Clear existing symptoms and create only test symptoms
        Symptom::query()->delete();
        
        // Create symptoms in different categories
        Symptom::factory()->create(['category' => 'performance', 'name' => 'Power Loss']);
        Symptom::factory()->create(['category' => 'sound', 'name' => 'Engine Noise']);
        Symptom::factory()->create(['category' => 'visual', 'name' => 'Smoke']);
        
        $service = new EngineExpertService();
        $symptoms = $service->getAvailableSymptoms();
        
        $this->assertArrayHasKey('performance', $symptoms);
        $this->assertArrayHasKey('sound', $symptoms);
        $this->assertArrayHasKey('visual', $symptoms);
        
        $this->assertCount(1, $symptoms['performance']);
        $this->assertEquals('Power Loss', $symptoms['performance'][0]['name']);
    }

    public function test_diagnosis_results_include_cost_estimates()
    {
        // Clear existing data and use fresh database
        DiagnosisRule::query()->delete();
        Diagnosis::query()->delete();
        Symptom::query()->delete();
        
        $service = new EngineExpertService();
        
        $symptom = Symptom::factory()->active()->create();
        $diagnosis = Diagnosis::factory()->active()->create([
            'estimated_cost_min' => 100.00,
            'estimated_cost_max' => 300.00,
        ]);
        
        DiagnosisRule::factory()->active()->create([
            'diagnosis_id' => $diagnosis->id,
            'required_symptoms' => [$symptom->id],
            'confidence_score' => 80,
            'priority' => 5,
        ]);
        
        $results = $service->diagnose([$symptom->id]);
        
        $this->assertNotEmpty($results['diagnosis_results']);
        $firstResult = $results['diagnosis_results'][0];
        
        $this->assertArrayHasKey('estimated_cost_range', $firstResult);
        $this->assertStringContainsString('$100', $firstResult['estimated_cost_range']);
        $this->assertStringContainsString('$300', $firstResult['estimated_cost_range']);
    }
}