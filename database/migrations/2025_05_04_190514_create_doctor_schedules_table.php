<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::create('doctor_schedules', function (Blueprint $table) {
        $table->id();
        $table->string('doctor_name');
        $table->enum('availability', ['present', 'absent'])->default('present');
        $table->string('start_time');
        $table->string('end_time');
        $table->timestamps();
    });
}
}
