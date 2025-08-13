<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DiagnosisRule
 *
 * @property int $id
 * @property int $diagnosis_id
 * @property array $required_symptoms
 * @property int $confidence_score
 * @property int $priority
 * @property string|null $rule_description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Diagnosis $diagnosis
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereConfidenceScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereDiagnosisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereRequiredSymptoms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereRuleDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule active()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisRule highPriority()
 * @method static \Database\Factories\DiagnosisRuleFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class DiagnosisRule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'diagnosis_id',
        'required_symptoms',
        'confidence_score',
        'priority',
        'rule_description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'required_symptoms' => 'array',
        'confidence_score' => 'integer',
        'priority' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active rules.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by priority (highest first).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHighPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    /**
     * Get the diagnosis that owns this rule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diagnosis(): BelongsTo
    {
        return $this->belongsTo(Diagnosis::class);
    }

    /**
     * Check if the given symptoms satisfy this rule.
     *
     * @param  array  $selectedSymptoms
     * @return bool
     */
    public function isSatisfiedBy(array $selectedSymptoms): bool
    {
        $requiredSymptoms = $this->required_symptoms ?? [];
        
        // Check if all required symptoms are present in selected symptoms
        return count(array_intersect($requiredSymptoms, $selectedSymptoms)) === count($requiredSymptoms);
    }

    /**
     * Calculate match percentage for the given symptoms.
     *
     * @param  array  $selectedSymptoms
     * @return float
     */
    public function calculateMatchPercentage(array $selectedSymptoms): float
    {
        $requiredSymptoms = $this->required_symptoms ?? [];
        
        if (empty($requiredSymptoms)) {
            return 0.0;
        }

        $matchingSymptoms = count(array_intersect($requiredSymptoms, $selectedSymptoms));
        return ($matchingSymptoms / count($requiredSymptoms)) * 100;
    }
}