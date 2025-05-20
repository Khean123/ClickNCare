<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointments extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'appointments'; 
    protected $primaryKey = 'id'; 
    protected $fillable = ['doctor', 'studentid', 'name', 'phone', 'appointment_date', 'email', 'status'];
    protected $dates = ['deleted_at']; // Add this line
}