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
use PDF;

class RecieptController extends Controller
{
   
    public function view($id)
    {
        // Retrieve the expense by receipt number
        $expense = StudentsExpense::where('reciept_no', $id)->first();      

        if($expense)
        {
            $studentmastr=StudentsExpenseMasterModel::where('id',$expense->expense_id)->first();
            $school = School::first();
            $student=Student::where('id', $expense->student_id)->first();

            $pdf = PDF::loadView('reciept.receipt_print', compact('expense', 'school','student','studentmastr'));
            return $pdf->stream('Payment Receipt-'.$id.'.pdf');
        }

        // Pass both expense and school data to the view
        //return view('reciept.template01', compact('expense', 'school','student','studentmastr'));
    }
}
