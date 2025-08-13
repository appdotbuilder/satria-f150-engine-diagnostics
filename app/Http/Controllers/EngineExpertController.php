<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiagnosisRequest;
use App\Services\EngineExpertService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EngineExpertController extends Controller
{
    /**
     * The engine expert service instance.
     *
     * @var EngineExpertService
     */
    protected $expertService;

    /**
     * Create a new controller instance.
     *
     * @param  EngineExpertService  $expertService
     * @return void
     */
    public function __construct(EngineExpertService $expertService)
    {
        $this->expertService = $expertService;
    }

    /**
     * Display the engine expert system interface.
     */
    public function index()
    {
        $symptoms = $this->expertService->getAvailableSymptoms();
        $categories = $this->expertService->getSymptomCategories();
        
        return Inertia::render('welcome', [
            'symptoms' => $symptoms,
            'categories' => $categories,
        ]);
    }

    /**
     * Process diagnosis based on selected symptoms.
     */
    public function store(StoreDiagnosisRequest $request)
    {
        $validated = $request->validated();
        
        $results = $this->expertService->diagnose(
            $validated['symptoms'],
            $validated['session_id'] ?? null,
            [
                'model' => $validated['motorcycle_model'] ?? 'Suzuki Satria F150',
                'year' => $validated['motorcycle_year'] ?? null,
                'mileage' => $validated['mileage'] ?? null,
            ]
        );
        
        $symptoms = $this->expertService->getAvailableSymptoms();
        $categories = $this->expertService->getSymptomCategories();
        
        return Inertia::render('welcome', [
            'symptoms' => $symptoms,
            'categories' => $categories,
            'diagnosis' => $results,
            'flash' => [
                'success' => 'Diagnosis completed successfully! Found ' . $results['total_results'] . ' possible issue(s).',
            ],
        ]);
    }
}