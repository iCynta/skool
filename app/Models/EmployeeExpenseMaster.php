<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeExpenseMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
    ];

    public function employeeExpenses()
    {
        return $this->hasMany(EmployeeExpense::class, 'expense_id');
    }

    public function employee()
    {
        return $this->hasManyThrough(User::class, EmployeeExpense::class, 'expense_id', 'id', 'id', 'employee_id');
    }
}
