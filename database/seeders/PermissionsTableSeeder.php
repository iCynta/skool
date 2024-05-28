<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define permissions
        $permissions = [
            'school_add',
            'school_delete',
            'school_edit',
            'school_view',
            'course_add',
            'course_delete',
            'course_edit',
            'course_view',
            'batch_add',
            'batch_delete',
            'batch_edit',
            'batch_view',
            'department_add',
            'department_delete',
            'department_edit',
            'department_view',
            'employee_add',
            'employee_delete',
            'employee_edit',
            'employee_view',
            'student_add',
            'student_delete',
            'student_edit',
            'student_view',
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
    }
}
