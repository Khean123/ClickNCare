<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\Contacts;
use App\Models\DoctorSchedule; 
use App\Models\User;

use DB;
class AppointmentController extends Controller
{
    
     public function __construct()
    {
        $this->middleware('auth')->except( 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index(Request $request)
{
    $perPage = 6;
    $currentPage = request()->has('page') ? request()->input('page') : 1;
    
    // Parse the sort parameter
    $sortParam = $request->get('sort_by');
    $sortParts = explode('-', $sortParam);
    $sortBy = $sortParts[0] ?? 'created_at';
    $sortOrder = $sortParts[1] ?? 'desc';

    // Validate sortable columns
    $validSortColumns = ['studentid', 'doctor', 'name', 'phone', 'appointment_date', 'email', 'created_at', 'status'];
    $sortBy = in_array($sortBy, $validSortColumns) ? $sortBy : 'created_at';
    $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? strtolower($sortOrder) : 'desc';

    $appointments = Appointments::orderBy($sortBy, $sortOrder)
        ->paginate($perPage, ['*'], 'page', $currentPage);
    
    $totalAppointmentsCount = Appointments::count();
    $totalContactsCount = Contacts::count();
    $totalUserCount = User::count();
    $totalDoctorSchedulesCount = DoctorSchedule::count(); // Add this line
    
    return view('backend.appointments.index', compact(
        'appointments',
        'totalAppointmentsCount',
        'totalContactsCount',
        'totalUserCount',
        'totalDoctorSchedulesCount',
        'currentPage',
        'sortBy',
        'sortOrder'
    ));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */

     public function store(Request $request)
     {
         try {
             $validatedData = $request->validate([
                 'doctor' => 'required',
                 'studentid' => 'required|string|max:255',
                 'name' => 'required',
                 'phone' => 'required|numeric|unique:appointments,phone',
                 'email' => 'required',
                 'appointment_date' => 'required|date',
             ]);
     
             // Add 'status' manually to the validated data
             $validatedData['status'] = 'Pending';
     
             $appointment = Appointments::create($validatedData);
     
             session()->flash('success', 'Appointment created successfully!, please check your email for confirmation.');
             return redirect()->back();
     
         } catch (\Illuminate\Validation\ValidationException $e) {
             if (auth()->check()) {
                 session()->flash('error', 'Appointment creation failed. Please try again.');
                 return redirect()->back();
             } else {
                 return response()->json(['status' => 0, 'message' => 'Failed to create an appointment. Please try again.']);
             }
         }
     }
     

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
 
    {
        $appointment = Appointments::findOrFail($id);
        $totalAppointmentsCount = Appointments::count();
        $totalContactsCount = Contacts::count();
        $totalUserCount = User::count(); // Add this line
        
        return view('backend.appointments.edit', compact('appointment', 'totalAppointmentsCount', 'totalContactsCount', 'totalUserCount'));
    }
    

  public function sendConfirmationEmail(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
        'subject' => 'required|string',
        'content' => 'required|string'
    ]);
    
    try {
        $appointment = Appointments::findOrFail($request->appointment_id);
        
        Mail::to($appointment->email)->send(new AppointmentConfirmation(
            $appointment,
            $request->subject,
            $request->content
        ));
        
        return response()->json([
            'success' => true,
            'message' => 'Confirmation email sent successfully'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send email: ' . $e->getMessage()
        ], 500);
    }
}

public function update(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'studentid' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'doctor' => 'required|string|max:255',
            'status' => 'required|in:Pending,Confirmed,Cancelled,Completed',
            'message' => 'nullable|string',
            'send_email' => 'nullable|boolean'
        ]);

        $appointment = Appointments::findOrFail($id);
        $originalStatus = $appointment->status;
        $emailSent = false;
        
        // Update the appointment first
        $appointment->update($validated);

        // Refresh the appointment to get updated data
        $appointment->refresh();

        // Send email if status changed to Confirmed and checkbox is checked
        if ($request->send_email && $appointment->status == 'Confirmed' && $originalStatus != 'Confirmed') {
            Mail::to($appointment->email)->send(new AppointmentConfirmation(
                $appointment,
                'Appointment Confirmation',
                $request->message // Use the message directly from the request
            ));
            $emailSent = true;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Appointment updated successfully!',
                'email_sent' => $emailSent,
                'email' => $appointment->email
            ]);
        }

        return redirect()->route('appointments-new')
            ->with('success', $emailSent 
                ? 'Appointment updated and confirmation email sent!'
                : 'Appointment updated successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput();

    } catch (\Exception $e) {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Error updating appointment: ' . $e->getMessage()
            ], 500);
        }

        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}
     /**
     * Remove all appointments from storage.
     *
     * @return \Illuminate\Http\Response
     */
   public function deleteAllAppointments()
{
    try {
        Appointments::query()->delete();
        return redirect()->route('appointments-new')
            ->with('success', 'All appointments moved to archive successfully!');
    } catch (\Exception $e) {
        return redirect()->route('appointments-new')
            ->with('error', 'Failed to archive appointments: ' . $e->getMessage());
    }
}
    public function destroy($id)
{
    try {
        $appointment = Appointments::findOrFail($id);
        $appointment->delete();
        
        return redirect()->route('appointments-new')
            ->with('success', 'Appointment moved to archive successfully!');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage());
    }
}
}         