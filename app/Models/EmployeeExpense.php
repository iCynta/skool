<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeExpense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'expense_id',
        'voucher_no',
        'created_by',
        'settled',
    ];
    protected $table= "employee_expenses";

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function expenseMaster()
    {
        return $this->belongsTo(EmployeeExpenseMaster::class, 'expense_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
