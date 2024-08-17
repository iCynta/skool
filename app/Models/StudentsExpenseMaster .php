<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsExpenseMaster extends Model
{
    use HasFactory;

    protected $table = 'students_expense_masters'; // Ensure this matches your table name

    protected $fillable = [
        // Define fillable attributes if necessary
    ];

    // Define relationships if necessary
}
