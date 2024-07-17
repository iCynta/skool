<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsExpense extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default 'students_expenses'
    protected $table = 'students_expenses';

    // Define the fields that are mass assignable
    protected $fillable = [
        'student_id',
        'expense_id',
        'reciept_no',
        'amount',
    ];

    // Define relationships if necessary
    // Assuming you have a Student model and an Expense model

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function expense()
    {
        return $this->belongsTo(StudentsExpenseMasterModel::class);
    }
}
