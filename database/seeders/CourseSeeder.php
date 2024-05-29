<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\School;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // Get the first school which is considered as the default school
        $school = School::first();
        // Check if a school exists
        if (!$school) {
            $this->command->info('No school found. Please seed the schools table first.');
            return;
        }
        $courses = [
            ['school_id' => $school->id, 'name' => 'Management', 'code' => 'management' ],
            ['school_id' => $school->id,'name' => 'Bachelor Of Education', 'code' => 'B.Ed'],
            ['school_id' => $school->id,'name' => 'Teacher Training Course', 'code' => 'T.T.C']
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
