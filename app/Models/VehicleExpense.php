<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleExpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'expense_id',
        'expense_type',
        'created_by',
        'amount',
        'fuel',
        'description'
    ];
}
