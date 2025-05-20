<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('frontend.index');
});

// Frontend routes (publicly accessible)
Route::get('/aboutus', function () { return view('frontend.aboutus'); });
Route::get('/bloggrid', function () { return view('frontend.bloggrid'); });
Route::get('/blogdetails', function () { return view('frontend.blogdetails'); });
Route::get('/booking', function () { return view('frontend.booking'); });
Route::get('/error404', function () { return view('frontend.error404'); });
Route::get('/faq', function () { return view('frontend.faq'); });
Route::get('/services', function () { return view('frontend.services'); });
Route::get('/servicedetail', function () { return view('frontend.servicedetail'); });
Route::get('/team', function () { return view('frontend.team'); });
Route::get('/contactus', function () { return view('frontend.contactus'); });

// Public form submission routes
Route::post('/appointments', [AppointmentController::class, 'store'])->name('submit.appointment');

// Authentication routes
Auth::routes();

// Backend routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Appointment routes
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('appointments-new');
        Route::delete('/', [AppointmentController::class, 'deleteAllAppointments'])->name('appointments.deleteAll');
        Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
        Route::post('/send-confirmation-email', [AppointmentController::class, 'sendConfirmationEmail'])
            ->name('appointments.send-confirmation-email');
    });
    
    // Contact routes
    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact-new');
        Route::post('/', [ContactController::class, 'store'])->name('submit.contact');
        Route::delete('/', [ContactController::class, 'deleteAllContacts'])->name('contacts.deleteAll');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    });
    
    // Doctor Schedule routes
   Route::prefix('doctor-schedule')->group(function () {
    Route::get('/', [DoctorScheduleController::class, 'index'])->name('doctor-schedule.index');
    Route::get('/create', [DoctorScheduleController::class, 'create'])->name('doctor-schedule.create');
    Route::post('/', [DoctorScheduleController::class, 'store'])->name('doctor-schedule.store');
    Route::get('/{id}/edit', [DoctorScheduleController::class, 'edit'])->name('doctor-schedule.edit');
    Route::put('/{id}', [DoctorScheduleController::class, 'update'])->name('doctor-schedule.update');
    Route::delete('/{id}', [DoctorScheduleController::class, 'destroy'])->name('doctor-schedule.destroy');
    Route::get('/doctor-schedule', [DoctorScheduleController::class, 'index'])->name('doctor-schedule.index');
Route::post('/doctor-schedule/toggle/{id}', [DoctorScheduleController::class, 'toggleAvailability'])->name('doctor-schedule.toggle');

});
    
    // User routes
    Route::resource('users', UserController::class);
});

// Test route (consider removing in production)
Route::get('/test-email', function() {
    Mail::raw('Test email content', function($message) {
        $message->to('test@example.com')->subject('Test Email');
    }); 
    return 'Email sent';
});

// Archive routes
Route::prefix('archive')->group(function () {
   Route::get('/{id}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::post('/{id}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::delete('/{id}/force-delete', [ArchiveController::class, 'forceDelete'])->name('archive.force-delete');
});

// Admin routes (protected by 'auth' and 'admin' middleware)
// Archive routes - accessible to both admins and doctors
Route::middleware(['auth'])->prefix('archive')->group(function () {
    Route::get('/', [ArchiveController::class, 'index'])->name('archive.index');
    Route::post('/{id}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::delete('/{id}/force-delete', [ArchiveController::class, 'forceDelete'])->name('archive.force-delete');
});

// Doctor routes (protected by 'auth' and 'doctor' middleware)
// Doctor routes (protected by 'auth' and 'doctor' middleware)
Route::middleware(['auth', 'doctor'])->group(function () {
    Route::prefix('doctor')->group(function () {
        // Add this line for the dashboard
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
        
        Route::get('/archive', [ArchiveController::class, 'index'])->name('doctor.archive.index');
    });
});
