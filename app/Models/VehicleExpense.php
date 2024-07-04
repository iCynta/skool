<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-M-Y h:i');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function expenseType()
    {
        return $this->belongsTo(VehicleExpenseMaster::class, 'expense_id');
    }

}
