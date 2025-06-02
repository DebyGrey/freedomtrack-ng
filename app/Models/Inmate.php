<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inmate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'inmate_id',
        'age',
        'gender',
        'crime_category',
        'sentence_length',
        'admission_date',
        'release_date',
        'parole_date',
        'behavior_score',
        'readiness_score',
        'status',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'release_date' => 'date',
        'parole_date' => 'date',
    ];

    /**
     * Get the programs that the inmate is enrolled in.
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'inmate_program')
            ->withPivot(['status', 'progress', 'enrollment_date', 'completion_date', 'certification'])
            ->withTimestamps();
    }

    /**
     * Check if inmate is eligible for parole
     */
    public function isParoleEligible()
    {
        return $this->parole_date && $this->parole_date <= now();
    }

    /**
     * Get the inmate's readiness level
     */
    public function getReadinessLevelAttribute()
    {
        if ($this->readiness_score >= 85) {
            return 'Excellent';
        } elseif ($this->readiness_score >= 70) {
            return 'Good';
        } elseif ($this->readiness_score >= 50) {
            return 'Fair';
        } else {
            return 'Poor';
        }
    }

    /**
     * Get the behavior level
     */
    public function getBehaviorLevelAttribute()
    {
        if ($this->behavior_score >= 8) {
            return 'Excellent';
        } elseif ($this->behavior_score >= 6) {
            return 'Good';
        } elseif ($this->behavior_score >= 4) {
            return 'Fair';
        } else {
            return 'Poor';
        }
    }
}
