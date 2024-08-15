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
        'created_by',
        'settled'
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }

    public function expense()
    {
        return $this->belongsTo(StudentsExpenseMasterModel::class);
    }


}
