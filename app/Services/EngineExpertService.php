<?php

namespace App\Services;

use App\Models\Diagnosis;
use App\Models\DiagnosisRule;
use App\Models\DiagnosisSession;
use App\Models\Symptom;
use Illuminate\Support\Collection;

class EngineExpertService
{
    /**
     * Diagnose engine issues using forward chaining reasoning.
     *
     * @param  array  $selectedSymptomIds
     * @param  string|null  $sessionId
     * @param  array  $motorcycleInfo
     * @return array
     */
    public function diagnose(array $selectedSymptomIds, ?string $sessionId = null, array $motorcycleInfo = []): array
    {
        // Create or update diagnosis session
        $session = $this->createOrUpdateSession($selectedSymptomIds, $sessionId, $motorcycleInfo);
        
        // Get all active diagnosis rules ordered by priority
        $rules = DiagnosisRule::with('diagnosis')
            ->active()
            ->highPriority()
            ->get();
        
        $diagnosisResults = [];
        $usedRules = [];
        
        // Forward chaining reasoning
        $inferredSymptoms = collect($selectedSymptomIds);
        $hasNewInferences = true;
        
        while ($hasNewInferences) {
            $hasNewInferences = false;
            
            foreach ($rules as $rule) {
                // Skip if rule already used
                if (in_array($rule->id, $usedRules)) {
                    continue;
                }
                
                // Check if rule is satisfied by current symptoms
                if ($rule->isSatisfiedBy($inferredSymptoms->toArray())) {
                    $diagnosis = $rule->diagnosis;
                    $confidence = $this->calculateConfidence($rule, $inferredSymptoms->toArray());
                    
                    // Add diagnosis to results
                    $diagnosisResults[] = [
                        'diagnosis' => $diagnosis,
                        'confidence' => $confidence,
                        'rule_id' => $rule->id,
                        'match_percentage' => $rule->calculateMatchPercentage($inferredSymptoms->toArray()),
                    ];
                    
                    $usedRules[] = $rule->id;
                    $hasNewInferences = true;
                }
            }
        }
        
        // Sort results by confidence score (descending)
        usort($diagnosisResults, function ($a, $b) {
            return $b['confidence'] <=> $a['confidence'];
        });
        
        // Limit to top 5 results
        $diagnosisResults = array_slice($diagnosisResults, 0, 5);
        
        // Save results to session
        $session->markAsDiagnosed($diagnosisResults);
        
        return [
            'session_id' => $session->session_id,
            'selected_symptoms' => $this->getSymptomDetails($selectedSymptomIds),
            'diagnosis_results' => $this->formatDiagnosisResults($diagnosisResults),
            'total_results' => count($diagnosisResults),
        ];
    }
    
    /**
     * Get all available symptoms grouped by category.
     *
     * @return array
     */
    public function getAvailableSymptoms(): array
    {
        $symptoms = Symptom::active()->orderBy('category')->orderBy('name')->get();
        
        return $symptoms->groupBy('category')->map(function ($categorySymptoms) {
            return $categorySymptoms->map(function ($symptom) {
                return [
                    'id' => $symptom->id,
                    'name' => $symptom->name,
                    'description' => $symptom->description,
                    'category' => $symptom->category,
                ];
            });
        })->toArray();
    }
    
    /**
     * Get symptom categories with counts.
     *
     * @return array
     */
    public function getSymptomCategories(): array
    {
        return Symptom::active()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->toArray();
    }
    
    /**
     * Calculate confidence score for a diagnosis rule.
     *
     * @param  DiagnosisRule  $rule
     * @param  array  $selectedSymptoms
     * @return int
     */
    protected function calculateConfidence(DiagnosisRule $rule, array $selectedSymptoms): int
    {
        $baseConfidence = $rule->confidence_score;
        $matchPercentage = $rule->calculateMatchPercentage($selectedSymptoms);
        
        // Adjust confidence based on match percentage and rule priority
        $adjustedConfidence = $baseConfidence * ($matchPercentage / 100);
        $priorityBonus = $rule->priority * 2; // Small priority bonus
        
        return min(100, (int) ($adjustedConfidence + $priorityBonus));
    }
    
    /**
     * Create or update diagnosis session.
     *
     * @param  array  $selectedSymptomIds
     * @param  string|null  $sessionId
     * @param  array  $motorcycleInfo
     * @return DiagnosisSession
     */
    protected function createOrUpdateSession(array $selectedSymptomIds, ?string $sessionId, array $motorcycleInfo): DiagnosisSession
    {
        if ($sessionId) {
            $session = DiagnosisSession::where('session_id', $sessionId)->first();
            if ($session) {
                $session->update([
                    'selected_symptoms' => $selectedSymptomIds,
                    'motorcycle_year' => $motorcycleInfo['year'] ?? null,
                    'mileage' => $motorcycleInfo['mileage'] ?? null,
                ]);
                return $session;
            }
        }
        
        return DiagnosisSession::create([
            'session_id' => DiagnosisSession::generateSessionId(),
            'selected_symptoms' => $selectedSymptomIds,
            'motorcycle_model' => $motorcycleInfo['model'] ?? 'Suzuki Satria F150',
            'motorcycle_year' => $motorcycleInfo['year'] ?? null,
            'mileage' => $motorcycleInfo['mileage'] ?? null,
        ]);
    }
    
    /**
     * Get symptom details by IDs.
     *
     * @param  array  $symptomIds
     * @return array
     */
    protected function getSymptomDetails(array $symptomIds): array
    {
        return Symptom::whereIn('id', $symptomIds)
            ->select('id', 'name', 'description', 'category')
            ->get()
            ->toArray();
    }
    
    /**
     * Format diagnosis results for response.
     *
     * @param  array  $results
     * @return array
     */
    protected function formatDiagnosisResults(array $results): array
    {
        return array_map(function ($result) {
            $diagnosis = $result['diagnosis'];
            
            return [
                'id' => $diagnosis->id,
                'name' => $diagnosis->name,
                'description' => $diagnosis->description,
                'possible_causes' => $diagnosis->possible_causes,
                'recommended_actions' => $diagnosis->recommended_actions,
                'severity' => $diagnosis->severity,
                'estimated_cost_range' => $diagnosis->estimated_cost_range,
                'confidence' => $result['confidence'],
                'match_percentage' => $result['match_percentage'],
            ];
        }, $results);
    }
}