<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization',
        // Add other doctor fields as needed
    ];

    // Relationship with schedules
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}