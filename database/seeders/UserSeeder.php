<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Course;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'Management']);
        $course = Course::firstOrCreate(['code' => 'management']);
        User::create([
            'name' => 'Super Admin',
            'email' => 'management@skool.com',
            'password' => Hash::make('admin123'),
            'role_id' => $role->id, // Assign the role ID
            'course_id' => $course->id, // Assign the role ID
            // Add other fields here if needed
        ]);
    }
}


