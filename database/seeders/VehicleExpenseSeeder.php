<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleExpenseMaster;

class VehicleExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseTypes = [
            'Fuel',
            'Insurance',
            'Maintenance',
            'Painting',
            'Penalty'
        ];
        
        foreach ($expenseTypes as $expenseType) {
            VehicleExpenseMaster::create([
                'name' => $expenseType,
            ]);
        }
    }
}
