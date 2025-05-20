<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        Doctor::create([
            'name' => 'Dr.Amores'
           
        ]);

        Doctor::create([
            'name' => 'Dr. Sarah Johnson'
          
        ]);
    }
}