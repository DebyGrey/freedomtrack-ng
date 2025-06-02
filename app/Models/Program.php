<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'duration',
        'capacity',
        'instructor',
        'start_date',
        'end_date',
        'status',
        'completion_rate',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function inmates()
    {
        return $this->belongsToMany(Inmate::class, 'inmate_program')
            ->withPivot('progress', 'completion_date', 'certification')
            ->withTimestamps();
    }

    public function getParticipantsCountAttribute()
    {
        return $this->inmates()->count();
    }
}
