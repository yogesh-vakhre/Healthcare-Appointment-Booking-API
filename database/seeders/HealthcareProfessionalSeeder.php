<?php

namespace Database\Seeders;

use App\Models\HealthcareProfessional;
use Illuminate\Database\Seeder;

class HealthcareProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HealthcareProfessional::factory(100)->create();
    }
}
