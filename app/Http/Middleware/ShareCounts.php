<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Appointments;
use App\Models\Contacts;
use App\Models\User;
use App\Models\DoctorSchedule;

class ShareCounts
{
    public function handle($request, Closure $next)
    {
        view()->share([
            'totalAppointmentsCount' => Appointments::count(),
            'totalContactsCount' => Contacts::count(),
            'totalUserCount' => User::count(),
            'totalDoctorSchedulesCount' => DoctorSchedule::count(),
        ]);

        return $next($request);
    }
}