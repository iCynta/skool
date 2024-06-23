<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SeatType;

class StudentSeatTypeSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seatTypes = [
            'Merit Seat',
            'Management Seat',
        ];
        
        foreach ($seatTypes as $seatType) {
            SeatType::create([
                'name' => $seatType,
                'status' => true, // Assuming 'status' is a column in your table
            ]);
        }
    }
}
