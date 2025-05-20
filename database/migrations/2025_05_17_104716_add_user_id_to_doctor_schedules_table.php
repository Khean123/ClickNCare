<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToDoctorSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::table('doctor_schedules', function (Blueprint $table) {
        // First add the column as nullable
        if (!Schema::hasColumn('doctor_schedules', 'user_id')) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        }
    });

    // Then populate it with valid user IDs
    $doctors = \App\Models\User::where('role', 'doctor')->get();
    foreach ($doctors as $doctor) {
        \App\Models\DoctorSchedule::where('doctor_name', $doctor->name)
            ->update(['user_id' => $doctor->id]);
    }

    // Now modify the column to be non-nullable and add the foreign key
    Schema::table('doctor_schedules', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable(false)->change();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
}
