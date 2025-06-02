<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BehaviorRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmate_id',
        'date',
        'type',
        'description',
        'points',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function inmate()
    {
        return $this->belongsTo(Inmate::class);
    }
}
