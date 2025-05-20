<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\Contacts;
use App\Models\User;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class DoctorDashboardController extends Controller
{
  public function __construct()
{
    $this->counts = [
        'totalAppointmentsCount' => Appointments::count(),
        'totalContactsCount' => Contacts::count(),
        'totalUserCount' => User::count(),
        'totalDoctorSchedulesCount' => DoctorSchedule::whereIn('doctor_name', 
            User::where('role', 'doctor')->pluck('name'))
            ->count()
    ];
}

  public function index()
{
    $today = Carbon::today();
    $doctorName = auth()->user()->name;

    // Get today's appointments for this doctor
    $todayAppointments = Appointments::whereDate('appointment_date', $today)
        ->where('doctor', $doctorName)
        ->orderBy('created_at', 'asc')
       ->get(['name', 'appointment_date', 'status', 'created_at']);


    // Count appointments by status for the chart (case-insensitive)
    $appointmentStats = [
        'confirmed' => Appointments::whereDate('appointment_date', $today)
    ->where('doctor', $doctorName)
    ->whereRaw('LOWER(status) = ?', ['confirmed'])
    ->count(),


        'pending' => Appointments::whereDate('appointment_date', $today)
            ->where('doctor', $doctorName)
            ->whereRaw('LOWER(status) = ?', ['pending'])
            ->count(),

        'cancelled' => Appointments::whereDate('appointment_date', $today)
            ->where('doctor', $doctorName)
            ->whereRaw('LOWER(status) = ?', ['cancelled'])
            ->count(),
    ];

    return view('doctor.dashboard', [
        'todayAppointments' => $todayAppointments,
        'appointmentStats' => $appointmentStats
    ]);
}

}