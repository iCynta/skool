<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            ['name' => 'St Johns Residential School', 'code' => 'STJRS' ],
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}
