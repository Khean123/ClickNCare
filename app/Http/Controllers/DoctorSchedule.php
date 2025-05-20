<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule; 
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor')->get(); 
        return view('doctor-schedule.index', compact('schedules'));
    }
}