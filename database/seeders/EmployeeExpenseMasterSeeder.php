<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeExpenseMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseCategories = [
            'Petty Cash',
            'Stationery',
            'Transportation Allowance',
            'Other Allowance',
            'Other Expense'
        ];

        foreach ($expenseCategories as $category) {
            DB::table('employee_expense_masters')->insert([
                'name' => $category,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
