<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixDoctorSchedulesStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('doctor_schedules', function (Blueprint $table) {
        // 1. Drop the doctor_id column if it exists
        if (Schema::hasColumn('doctor_schedules', 'doctor_id')) {
            $table->dropColumn('doctor_id');
        }

        // 2. Ensure doctor_name exists and is properly configured
        if (!Schema::hasColumn('doctor_schedules', 'doctor_name')) {
            $table->string('doctor_name')->after('id');
        }
    });
}
}