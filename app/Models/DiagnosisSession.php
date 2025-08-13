<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DiagnosisSession
 *
 * @property int $id
 * @property string $session_id
 * @property array $selected_symptoms
 * @property array|null $diagnosis_results
 * @property \Illuminate\Support\Carbon|null $diagnosed_at
 * @property string $motorcycle_model
 * @property int|null $motorcycle_year
 * @property int|null $mileage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereDiagnosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereDiagnosisResults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereMotorcycleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereMotorcycleYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereSelectedSymptoms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosisSession diagnosed()
 * @method static \Database\Factories\DiagnosisSessionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class DiagnosisSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'session_id',
        'selected_symptoms',
        'diagnosis_results',
        'diagnosed_at',
        'motorcycle_model',
        'motorcycle_year',
        'mileage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'selected_symptoms' => 'array',
        'diagnosis_results' => 'array',
        'diagnosed_at' => 'datetime',
        'motorcycle_year' => 'integer',
        'mileage' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include diagnosed sessions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDiagnosed($query)
    {
        return $query->whereNotNull('diagnosed_at');
    }

    /**
     * Generate a unique session ID.
     *
     * @return string
     */
    public static function generateSessionId(): string
    {
        return 'diag_' . time() . '_' . random_int(1000, 9999);
    }

    /**
     * Mark this session as diagnosed.
     *
     * @param  array  $results
     * @return void
     */
    public function markAsDiagnosed(array $results): void
    {
        $this->update([
            'diagnosis_results' => $results,
            'diagnosed_at' => now(),
        ]);
    }
}