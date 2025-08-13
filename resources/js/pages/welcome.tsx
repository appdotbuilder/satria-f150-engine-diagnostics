import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import { AlertCircle, CheckCircle, Wrench, Car, Search, Zap } from 'lucide-react';

interface Symptom {
    id: number;
    name: string;
    description: string;
    category: string;
}

interface SymptomCategory {
    category: string;
    count: number;
}

interface DiagnosisResult {
    id: number;
    name: string;
    description: string;
    possible_causes: string;
    recommended_actions: string;
    severity: 'low' | 'medium' | 'high' | 'critical';
    estimated_cost_range: string;
    confidence: number;
    match_percentage: number;
}

interface DiagnosisData {
    session_id: string;
    selected_symptoms: Symptom[];
    diagnosis_results: DiagnosisResult[];
    total_results: number;
}

interface Props {
    symptoms: Record<string, Symptom[]>;
    categories: SymptomCategory[];
    diagnosis?: DiagnosisData;
    flash?: {
        success?: string;
    };
    [key: string]: unknown;
}

const severityColors = {
    low: 'bg-green-100 text-green-800 border-green-200',
    medium: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    high: 'bg-orange-100 text-orange-800 border-orange-200',
    critical: 'bg-red-100 text-red-800 border-red-200',
};

const severityIcons = {
    low: '✅',
    medium: '⚠️',
    high: '🔥',
    critical: '🚨',
};

export default function Welcome({ symptoms, diagnosis, flash }: Props) {
    const [selectedSymptoms, setSelectedSymptoms] = useState<number[]>([]);
    const [motorcycleYear, setMotorcycleYear] = useState<string>('');
    const [mileage, setMileage] = useState<string>('');
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [activeCategory, setActiveCategory] = useState<string>('all');

    // Get all symptoms for filtering
    const allSymptoms = Object.values(symptoms).flat();
    const filteredSymptoms = activeCategory === 'all' 
        ? allSymptoms 
        : allSymptoms.filter(symptom => symptom.category === activeCategory);

    const handleSymptomToggle = (symptomId: number) => {
        setSelectedSymptoms(prev => 
            prev.includes(symptomId)
                ? prev.filter(id => id !== symptomId)
                : [...prev, symptomId]
        );
    };

    const handleDiagnosis = () => {
        if (selectedSymptoms.length === 0) {
            return;
        }

        setIsSubmitting(true);
        router.post(route('engine-expert.store'), {
            symptoms: selectedSymptoms,
            session_id: diagnosis?.session_id,
            motorcycle_model: 'Suzuki Satria F150',
            motorcycle_year: motorcycleYear ? parseInt(motorcycleYear) : null,
            mileage: mileage ? parseInt(mileage) : null,
        }, {
            preserveState: true,
            preserveScroll: true,
            onFinish: () => setIsSubmitting(false),
        });
    };

    const handleReset = () => {
        setSelectedSymptoms([]);
        setMotorcycleYear('');
        setMileage('');
        router.get('/');
    };

    // Get category display names
    const getCategoryDisplayName = (category: string) => {
        const categoryNames: Record<string, string> = {
            performance: '⚙️ Performance',
            sound: '🔊 Sound',
            visual: '👁️ Visual',
            electrical: '⚡ Electrical',
            fuel: '⛽ Fuel System',
            temperature: '🌡️ Temperature',
            vibration: '📳 Vibration',
        };
        return categoryNames[category] || category;
    };

    return (
        <>
            <Head title="Suzuki Satria F150 Engine Expert System" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
                {/* Header */}
                <div className="bg-white shadow-sm border-b">
                    <div className="max-w-7xl mx-auto px-4 py-6">
                        <div className="text-center">
                            <h1 className="text-4xl font-bold text-gray-900 mb-2">
                                🏍️ Suzuki Satria F150 Engine Expert System
                            </h1>
                            <p className="text-xl text-gray-600">
                                AI-Powered Motorcycle Engine Diagnosis using Forward Chaining
                            </p>
                        </div>
                    </div>
                </div>

                <div className="max-w-7xl mx-auto px-4 py-8">
                    {/* Introduction Card */}
                    {!diagnosis && (
                        <Card className="mb-8 bg-gradient-to-r from-blue-500 to-purple-600 text-white border-0">
                            <CardHeader>
                                <CardTitle className="text-2xl flex items-center gap-2">
                                    <Wrench className="h-8 w-8" />
                                    Welcome to the Engine Expert System
                                </CardTitle>
                                <CardDescription className="text-blue-100 text-lg">
                                    Get instant, professional engine diagnostics for your Suzuki Satria F150
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div className="grid md:grid-cols-3 gap-4">
                                    <div className="flex items-center gap-3">
                                        <Search className="h-6 w-6 text-blue-200" />
                                        <div>
                                            <h3 className="font-semibold">Select Symptoms</h3>
                                            <p className="text-sm text-blue-100">Choose what issues you're experiencing</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <Zap className="h-6 w-6 text-blue-200" />
                                        <div>
                                            <h3 className="font-semibold">AI Analysis</h3>
                                            <p className="text-sm text-blue-100">Forward chaining reasoning for accurate diagnosis</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <Car className="h-6 w-6 text-blue-200" />
                                        <div>
                                            <h3 className="font-semibold">Expert Results</h3>
                                            <p className="text-sm text-blue-100">Get professional repair recommendations</p>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    )}

                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Left Column - Symptom Selection */}
                        <div className="lg:col-span-2 space-y-6">
                            {/* Motorcycle Information */}
                            <Card>
                                <CardHeader>
                                    <CardTitle>🏍️ Motorcycle Information</CardTitle>
                                    <CardDescription>
                                        Optional: Provide additional details for more accurate diagnosis
                                    </CardDescription>
                                </CardHeader>
                                <CardContent className="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <Label htmlFor="year">Motorcycle Year</Label>
                                        <Input
                                            id="year"
                                            type="number"
                                            min="1990"
                                            max={new Date().getFullYear() + 1}
                                            placeholder="e.g., 2020"
                                            value={motorcycleYear}
                                            onChange={(e) => setMotorcycleYear(e.target.value)}
                                        />
                                    </div>
                                    <div>
                                        <Label htmlFor="mileage">Mileage (km)</Label>
                                        <Input
                                            id="mileage"
                                            type="number"
                                            min="0"
                                            placeholder="e.g., 15000"
                                            value={mileage}
                                            onChange={(e) => setMileage(e.target.value)}
                                        />
                                    </div>
                                </CardContent>
                            </Card>

                            {/* Category Filter */}
                            <Card>
                                <CardHeader>
                                    <CardTitle>📋 Symptom Categories</CardTitle>
                                    <CardDescription>
                                        Filter symptoms by category or view all
                                    </CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="flex flex-wrap gap-2">
                                        <Button
                                            variant={activeCategory === 'all' ? 'default' : 'outline'}
                                            onClick={() => setActiveCategory('all')}
                                            size="sm"
                                        >
                                            All Symptoms ({allSymptoms.length})
                                        </Button>
                                        {Object.keys(symptoms).map(category => (
                                            <Button
                                                key={category}
                                                variant={activeCategory === category ? 'default' : 'outline'}
                                                onClick={() => setActiveCategory(category)}
                                                size="sm"
                                            >
                                                {getCategoryDisplayName(category)} ({symptoms[category].length})
                                            </Button>
                                        ))}
                                    </div>
                                </CardContent>
                            </Card>

                            {/* Symptoms Selection */}
                            <Card>
                                <CardHeader>
                                    <CardTitle>⚠️ Select Symptoms</CardTitle>
                                    <CardDescription>
                                        Choose all symptoms you're experiencing with your Suzuki Satria F150
                                        {selectedSymptoms.length > 0 && (
                                            <span className="ml-2 text-blue-600 font-semibold">
                                                ({selectedSymptoms.length} selected)
                                            </span>
                                        )}
                                    </CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="grid gap-3">
                                        {filteredSymptoms.map(symptom => (
                                            <div key={symptom.id} className="flex items-start space-x-3 p-3 border rounded-lg hover:bg-gray-50">
                                                <Checkbox
                                                    id={`symptom-${symptom.id}`}
                                                    checked={selectedSymptoms.includes(symptom.id)}
                                                    onCheckedChange={() => handleSymptomToggle(symptom.id)}
                                                />
                                                <div className="flex-1">
                                                    <Label 
                                                        htmlFor={`symptom-${symptom.id}`}
                                                        className="text-base font-medium cursor-pointer"
                                                    >
                                                        {symptom.name}
                                                    </Label>
                                                    <p className="text-sm text-gray-600 mt-1">
                                                        {symptom.description}
                                                    </p>
                                                    <Badge variant="secondary" className="mt-2">
                                                        {getCategoryDisplayName(symptom.category)}
                                                    </Badge>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </CardContent>
                            </Card>

                            {/* Action Buttons */}
                            <div className="flex gap-4">
                                <Button 
                                    onClick={handleDiagnosis}
                                    disabled={selectedSymptoms.length === 0 || isSubmitting}
                                    className="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-6 text-lg"
                                    size="lg"
                                >
                                    {isSubmitting ? (
                                        <>🔄 Analyzing...</>
                                    ) : (
                                        <>🔍 Diagnose Engine Issues ({selectedSymptoms.length})</>
                                    )}
                                </Button>
                                {diagnosis && (
                                    <Button 
                                        onClick={handleReset}
                                        variant="outline"
                                        size="lg"
                                        className="py-6"
                                    >
                                        🔄 New Diagnosis
                                    </Button>
                                )}
                            </div>
                        </div>

                        {/* Right Column - Results */}
                        <div className="space-y-6">
                            {diagnosis && (
                                <>
                                    {/* Success Message */}
                                    {flash?.success && (
                                        <Card className="border-green-200 bg-green-50">
                                            <CardContent className="pt-6">
                                                <div className="flex items-center gap-2 text-green-800">
                                                    <CheckCircle className="h-5 w-5" />
                                                    <p className="font-medium">{flash.success}</p>
                                                </div>
                                            </CardContent>
                                        </Card>
                                    )}

                                    {/* Diagnosis Results */}
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className="flex items-center gap-2">
                                                <AlertCircle className="h-6 w-6" />
                                                Diagnosis Results
                                            </CardTitle>
                                            <CardDescription>
                                                Based on {diagnosis.selected_symptoms.length} symptoms
                                            </CardDescription>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-6">
                                                {diagnosis.diagnosis_results.length === 0 ? (
                                                    <div className="text-center py-8 text-gray-500">
                                                        <AlertCircle className="h-12 w-12 mx-auto mb-4 text-gray-400" />
                                                        <p>No specific diagnosis found for the selected symptoms.</p>
                                                        <p className="text-sm mt-2">Try selecting more symptoms or consult a professional mechanic.</p>
                                                    </div>
                                                ) : (
                                                    diagnosis.diagnosis_results.map((result, index) => (
                                                        <div key={result.id} className="border rounded-lg p-4 space-y-3">
                                                            <div className="flex items-center justify-between">
                                                                <h3 className="font-bold text-lg flex items-center gap-2">
                                                                    <span className="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-sm font-semibold">
                                                                        #{index + 1}
                                                                    </span>
                                                                    {result.name}
                                                                </h3>
                                                                <div className="flex gap-2">
                                                                    <Badge className={severityColors[result.severity]}>
                                                                        {severityIcons[result.severity]} {result.severity.toUpperCase()}
                                                                    </Badge>
                                                                    <Badge variant="outline">
                                                                        {result.confidence}% Confidence
                                                                    </Badge>
                                                                </div>
                                                            </div>

                                                            <p className="text-gray-700">{result.description}</p>

                                                            <div className="space-y-3">
                                                                <div>
                                                                    <h4 className="font-semibold text-sm text-gray-800 mb-1">🔍 Possible Causes:</h4>
                                                                    <p className="text-sm text-gray-600">{result.possible_causes}</p>
                                                                </div>

                                                                <div>
                                                                    <h4 className="font-semibold text-sm text-gray-800 mb-1">🔧 Recommended Actions:</h4>
                                                                    <p className="text-sm text-gray-600">{result.recommended_actions}</p>
                                                                </div>

                                                                <div className="flex justify-between items-center pt-2 border-t">
                                                                    <div>
                                                                        <span className="text-sm font-semibold text-gray-700">Estimated Cost: </span>
                                                                        <span className="text-sm text-green-600 font-bold">{result.estimated_cost_range}</span>
                                                                    </div>
                                                                    <div className="text-xs text-gray-500">
                                                                        Match: {Math.round(result.match_percentage)}%
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    ))
                                                )}
                                            </div>
                                        </CardContent>
                                    </Card>

                                    {/* Selected Symptoms Summary */}
                                    <Card>
                                        <CardHeader>
                                            <CardTitle>✅ Selected Symptoms</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-2">
                                                {diagnosis.selected_symptoms.map(symptom => (
                                                    <div key={symptom.id} className="flex items-center gap-2 text-sm">
                                                        <Badge variant="outline">{getCategoryDisplayName(symptom.category)}</Badge>
                                                        <span className="font-medium">{symptom.name}</span>
                                                    </div>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                </>
                            )}

                            {!diagnosis && (
                                <Card className="bg-gray-50">
                                    <CardHeader>
                                        <CardTitle>💡 How It Works</CardTitle>
                                    </CardHeader>
                                    <CardContent className="space-y-3 text-sm">
                                        <div className="flex items-start gap-2">
                                            <span className="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs font-semibold mt-0.5">1</span>
                                            <p>Select all symptoms you observe with your motorcycle</p>
                                        </div>
                                        <div className="flex items-start gap-2">
                                            <span className="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs font-semibold mt-0.5">2</span>
                                            <p>Our AI uses forward chaining reasoning to analyze symptom patterns</p>
                                        </div>
                                        <div className="flex items-start gap-2">
                                            <span className="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs font-semibold mt-0.5">3</span>
                                            <p>Get ranked diagnosis results with confidence scores and cost estimates</p>
                                        </div>
                                        <div className="flex items-start gap-2">
                                            <span className="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs font-semibold mt-0.5">4</span>
                                            <p>Follow professional repair recommendations</p>
                                        </div>
                                    </CardContent>
                                </Card>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}