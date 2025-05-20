<?php

namespace Database\Seeders;

use App\Models\User;  // Add this import
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DoctorSeeder::class,
            // Other seeders...
        ]);
    
    }
}