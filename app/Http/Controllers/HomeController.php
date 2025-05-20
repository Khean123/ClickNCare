<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\Contacts;
use App\Models\User;
use App\Models\DoctorSchedule; // Add this line
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $user = auth()->user();

    if ($user->role === 'doctor') {
        return redirect()->route('doctor.dashboard');
    }

    // Continue for admin
    $latestAppointments = Appointments::latest()->take(10)->get();
    $thisMonthContacts = $this->getThisMonthContacts();
    $thisMonthUsers = $this->getThisMonthUsers();
    $thisMonthAppointments = $this->getThisMonthAppointments();
    $thisMonthDoctorSchedules = $this->getThisMonthDoctorSchedules();
    
    $totalAppointmentsCount = Appointments::count();
    $totalContactsCount = Contacts::count();
    $totalUserCount = User::count();
    $totalDoctorSchedulesCount = DoctorSchedule::count();

    $chartData = $this->prepareChartData(
        $thisMonthContacts, 
        $thisMonthUsers, 
        $thisMonthAppointments,
        $thisMonthDoctorSchedules
    );

    return view('home', [
        'totalAppointmentsCount' => $totalAppointmentsCount,
        'totalContactsCount' => $totalContactsCount,
        'totalUserCount' => $totalUserCount,
        'totalDoctorSchedulesCount' => $totalDoctorSchedulesCount,
        'latestAppointments' => $latestAppointments,
        'chartData' => $chartData,
    ]);
}


    public function prepareChartData($contacts, $users, $appointments, $doctorSchedules)
    {
        $currentMonth = Carbon::now()->format('M');
        $chartData = [
            ['Month', 'Contacts', 'Users', 'Appointments', 'Doctor Schedules'],
            [$currentMonth, $contacts, $users, $appointments, $doctorSchedules],
        ];

        return json_encode($chartData);
    }
    
    public function getThisMonthContacts()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $monthly_contacts = Contacts::whereMonth('created_at', $currentMonth->month)
                                   ->whereYear('created_at', $currentMonth->year)
                                   ->get();
    
        return $monthly_contacts->count();
    }
    
    public function getThisMonthUsers()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $monthly_users = User::whereMonth('created_at', $currentMonth->month)
                                   ->whereYear('created_at', $currentMonth->year)
                                   ->get();
    
        return $monthly_users->count();
    }
    
    public function getThisMonthAppointments()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $monthly_appointments = Appointments::whereMonth('created_at', $currentMonth->month)
                                   ->whereYear('created_at', $currentMonth->year)
                                   ->get();
    
        return $monthly_appointments->count();
    }

    // Add this new method for doctor schedules
    public function getThisMonthDoctorSchedules()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $monthly_schedules = DoctorSchedule::whereMonth('date', $currentMonth->month)
                                   ->whereYear('date', $currentMonth->year)
                                   ->get();
    
        return $monthly_schedules->count();
    }
}