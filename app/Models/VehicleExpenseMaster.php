<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleExpenseMaster extends Model
{
    use HasFactory;
    protected $table = "vehicle_expense_master";
    protected $fillable = [
        'name',
    ];
}
