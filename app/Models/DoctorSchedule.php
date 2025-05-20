<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_name',  
        'date',
        'start_time',
        'end_time',
        'availability',
        'user_id'  // Add this to fillable
    ];
    
    protected $casts = [
        'date' => 'date:Y-m-d',
        'start_time' => 'string',
        'end_time' => 'string'
    ];

    // Relationship to User
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Updated availability status method
    public function getAvailabilityStatusAttribute()
    {
        $statuses = [
            'present' => ['text' => 'Available', 'color' => 'green'],
            'absent' => ['text' => 'Unavailable', 'color' => 'red'],
        ];
        
        return $statuses[$this->availability] ?? ['text' => 'Unknown', 'color' => 'gray'];
    }
}