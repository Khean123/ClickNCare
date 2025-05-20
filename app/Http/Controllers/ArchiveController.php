<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index()
{
    $archivedAppointments = Appointments::onlyTrashed()
        ->orderBy('deleted_at', 'desc')
        ->paginate(10); // or your preferred pagination count
    
    // Use your existing backend/archive/index.blade.php view
    return view('backend.archive.index', compact('archivedAppointments'));
}

    public function restore($id)
    {
        $appointment = Appointments::onlyTrashed()->findOrFail($id);
        $appointment->restore();
        
        return redirect()->route('archive.index')
            ->with('success', 'Appointment restored successfully!');
    }

    public function forceDelete($id)
    {
        $appointment = Appointments::onlyTrashed()->findOrFail($id);
        $appointment->forceDelete();
        
        return redirect()->route('archive.index')
            ->with('success', 'Appointment permanently deleted!');
    }
}