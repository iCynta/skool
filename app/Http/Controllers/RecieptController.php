<?php

namespace App\Http\Controllers;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Department;
use App\Models\SeatType;
use App\Models\Student;
use App\Models\User;
use App\Models\StudentsExpenseMasterModel;
use App\Models\StudentsExpense;
use App\Models\School;
use Illuminate\Http\Request;

class RecieptController extends Controller
{
   
    public function view($id)
    {
        // Retrieve the expense by receipt number
        $expense = StudentsExpense::where('reciept_no', $id)->first();
        $studentmastr=StudentsExpenseMasterModel::where('id',$expense->expense_id)->first();
        // Retrieve the school details
        $school = School::first();
        $student=Student::where('id', $expense->student_id)->first();
        // Pass both expense and school data to the view
        return view('reciept.template01', compact('expense', 'school','student','studentmastr'));
    }
}
