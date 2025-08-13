<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Symptom
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $category
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DiagnosisRule> $diagnosisRules
 * @property-read int|null $diagnosis_rules_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom query()
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom active()
 * @method static \Illuminate\Database\Eloquent\Builder|Symptom byCategory(string $category)
 * @method static \Database\Factories\SymptomFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Symptom extends Model
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
        'category',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active symptoms.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the diagnosis rules that reference this symptom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function diagnosisRules(): BelongsToMany
    {
        return $this->belongsToMany(DiagnosisRule::class, 'diagnosis_rule_symptoms');
    }
}