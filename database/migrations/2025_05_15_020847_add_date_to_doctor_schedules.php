<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToDoctorSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::table('doctor_schedules', function (Blueprint $table) {
        $table->date('date')->after('doctor_name');
    });
}

public function down()
{
    Schema::table('doctor_schedules', function (Blueprint $table) {
        $table->dropColumn('date');
    });
}
}
