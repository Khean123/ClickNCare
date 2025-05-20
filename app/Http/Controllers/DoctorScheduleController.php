<?php

namespace App\Http\Controllers;
use App\Models\Doctor;  // Add this line
use App\Models\DoctorSchedule;
use App\Models\Appointments;
use App\Models\Contacts;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    protected $counts;
    
    public function __construct()
    {
        $this->counts = [
            'totalAppointmentsCount' => Appointments::count(),
            'totalContactsCount' => Contacts::count(),
            'totalUserCount' => User::count()
        ];
    }

   public function index()
{
    $doctors = User::where('role', 'doctor')->get();

    return view('doctor-schedule.index', array_merge($this->counts, [
        'doctors' => $doctors
    ]));
}

   public function create()
{
    $doctors = User::where('role', 'doctor')->get();

    return view('doctor-schedule.create', array_merge($this->counts, [
        'doctors' => $doctors
    ]));
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'doctor_name' => 'required|string',  // Changed from doctor_id
        'date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'availability' => 'required|in:present,absent'
    ]);

    try {
        DoctorSchedule::create($validated);
        return redirect()->route('doctor-schedule.index')
                       ->with('success', 'Schedule added successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to create schedule: '.$e->getMessage())
                    ->withInput();
    }
}

   
    
    public function deleteAll()
    {
        DoctorSchedule::truncate();
        return redirect()->route('doctor-schedule.index')
                       ->with('success', 'All schedules deleted!');
    }
    // Add these methods to your DoctorScheduleController

public function edit($id)
{
    $schedule = DoctorSchedule::findOrFail($id);
    $doctors = Doctor::all();
    
    return view('doctor-schedule.edit', array_merge($this->counts, [
        'schedule' => $schedule,
        'doctors' => $doctors
    ]));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
          'doctor_name' => 'required|string',
        'date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'availability' => 'required|in:present,absent'
    ]);

    try {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->update($validated);
        
        return redirect()->route('doctor-schedule.index')
                       ->with('success', 'Schedule updated successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to update schedule: '.$e->getMessage())
                    ->withInput();
    }
}

public function destroy($id)
{
    try {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();
        
        return redirect()->route('doctor-schedule.index')
                       ->with('success', 'Schedule deleted successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to delete schedule: '.$e->getMessage());
    }
}
public function toggleAvailability(Request $request, $id)
{
    $doctor = User::findOrFail($id);
    
    $validated = $request->validate([
        'availability' => 'required|in:present,absent'
    ]);

    $today = now()->toDateString();
    
    // Find or create schedule for this doctor today
    $schedule = DoctorSchedule::updateOrCreate(
        [
            'user_id' => $id,
            'date' => $today
        ],
        [
            'doctor_name' => $doctor->name,
            'start_time' => now()->format('H:i'),
            'end_time' => now()->addHour()->format('H:i'),
            'availability' => $validated['availability']
        ]
    );

    return redirect()->route('doctor-schedule.index')->with('success', 'Availability updated.');
}
}
