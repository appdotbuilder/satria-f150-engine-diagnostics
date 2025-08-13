<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Diagnosis
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $possible_causes
 * @property string $recommended_actions
 * @property string $severity
 * @property float|null $estimated_cost_min
 * @property float|null $estimated_cost_max
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DiagnosisRule> $rules
 * @property-read int|null $rules_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis query()
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereEstimatedCostMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereEstimatedCostMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis wherePossibleCauses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereRecommendedActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis active()
 * @method static \Illuminate\Database\Eloquent\Builder|Diagnosis bySeverity(string $severity)
 * @method static \Database\Factories\DiagnosisFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Diagnosis extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'possible_causes',
        'recommended_actions',
        'severity',
        'estimated_cost_min',
        'estimated_cost_max',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'estimated_cost_min' => 'decimal:2',
        'estimated_cost_max' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active diagnoses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by severity.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $severity
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySeverity($query, string $severity)
    {
        return $query->where('severity', $severity);
    }

    /**
     * Get the diagnosis rules for this diagnosis.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rules(): HasMany
    {
        return $this->hasMany(DiagnosisRule::class);
    }

    /**
     * Get the estimated cost range as a formatted string.
     *
     * @return string
     */
    public function getEstimatedCostRangeAttribute(): string
    {
        if (!$this->estimated_cost_min && !$this->estimated_cost_max) {
            return 'Cost estimate not available';
        }

        if ($this->estimated_cost_min && $this->estimated_cost_max) {
            return '$' . number_format($this->estimated_cost_min, 0) . ' - $' . number_format($this->estimated_cost_max, 0);
        }

        if ($this->estimated_cost_min) {
            return 'Starting from $' . number_format($this->estimated_cost_min, 0);
        }

        return 'Up to $' . number_format($this->estimated_cost_max, 0);
    }
}