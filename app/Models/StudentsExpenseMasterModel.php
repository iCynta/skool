<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentsExpenseMasterModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students_expense_masters'; // Specify the table name

    protected $fillable = [
        'id',
        'expense_name',
        'created_at',
        'status'
    ];
}
