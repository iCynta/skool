<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Department;
use App\Models\StudentsExpense;
use App\Models\StudentsExpenseMasterModel;
use App\Models\School;
use Illuminate\Http\Request;

class StudentsExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = StudentsExpenseMasterModel::all(); // Adjust as necessary
   
        return view('students.students_expenses', compact('expenses'));
    }
    public function calculateMonthsPaid($totalFees, $amountPaid, $totalMonths)
    {
        if ($totalMonths <= 0) {
            return "Total months must be greater than zero.";
        }
        if ($amountPaid < 0) {
            return "Amount paid cannot be negative.";
        }

        // Calculate the monthly installment amount
        $monthlyInstallment = $totalFees / $totalMonths;

        // Calculate the number of months paid
        $monthsPaid = floor($amountPaid / $monthlyInstallment);

        return $monthsPaid;
    }
    public function searchStudentsDetails(Request $request)
    {
        $students=Student::where('id',$request->admission_no)->first();
     
        $batch=Batch::where('id',$students->batch_id)->first();
        $Course=Course::where('id',$students->course_id)->first();
        $Department=Department::where('id',$students->department_id)->first();
      
        $totalInstallments=$batch->course_tenure;
        $totalFees = $batch->tution_fee; // Total fees
        $amountPaid = StudentsExpense::where('student_id', $request->admission_no)
        ->where('expense_id', 1)
        ->sum('amount'); // Amount paid
        $totalMonths = $batch->course_tenure; // Total months for payment
        $balance=$totalFees-$amountPaid;
        $monthsPaid = $this->calculateMonthsPaid($totalFees, $amountPaid, $totalMonths);
        $donationPaid = StudentsExpense::where('student_id', $request->admission_no)
        ->where('expense_id', 2)
        ->sum('amount'); // Amount paid
        $response = [
            'status' => 200,
            'batch' =>$batch->name,
            'name' =>$students->name,
            'course'=>$Course->name,
            'department'=>$Department->name,
            'dob'=>$students->dob,
            'coursefee'=>$batch->tution_fee.' INR',
            'tenuture'=>$batch->course_tenure.' Months',
            'paidinst'=>$monthsPaid,
            'TotalamtPaid'=>$amountPaid.' INR',
            'balancefee'=>$balance.' INR',
            'donation'=>$donationPaid.' INR'
        ];
    
        // Return JSON response
        return response()->json($response);

    }
    public function loadExpenseReciepts(Request $request)
    {
        // Adjust the pagination size as needed
        $students = StudentsExpense::where('student_id',$request->admission_no)->get();
    
        $disp = ''; // Initialize $disp to avoid undefined variable notice
    
        foreach ($students as $student) {
            $std=StudentsExpenseMasterModel::where('id',$student->expense_id)->first();
            $disp .= '<tr>';
            $disp .= '<td>' . $student->id . '</td>';
            $disp .= '<td>' . $student->created_at . '</td>';
            $disp .= '<td>' . $std->expense_name . '</td>';
            $disp .= '<td><a  target="_blank" href="' . route('reciepts', ['id' => $student->reciept_no]) . '">' . $student->reciept_no . '</a></td>';
            $disp .= '<td>' . $student->amount . '</td>';
            $disp .= '<td><button type="button" class="btn btn-danger" data-id="'.$student->id.'" data-expense_name ="'.$student->expense_id.'"  data-amount ="'.$student->amount.'"onclick="editExpense(this)">Edit</button></td>';
            $disp .= '</tr>';
        }

    
        // $paginate = $students->links('vendor.pagination.bootstrap-4')->toHtml();
    
        $response = [
            'status' => 200,
            'data' => $disp,
            // 'links' => $paginate
        ];
        return response()->json($response);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data if needed
        $validatedData = ['student_id'=>$request->admission_no,'expense_id'=>$request->expense_id,'amount'=>$request->amount];
    
        // Create the student and retrieve the instance
        $student = StudentsExpense::create($validatedData);
    
        // Generate the receipt number using the last incremented ID
        $receipt_no = 'REC-' . str_pad($student->id, 6, '0', STR_PAD_LEFT); // e.g., REC-000001
    
        // Update the student with the receipt number
        $student->update(['reciept_no' => $receipt_no]);
    
        $response = [
            'status' => 200,
            'msg' => 'Student created successfully.',
            'receipt_no' => $receipt_no // Optional: return the receipt number
        ];
    
        // Return JSON response
      return response()->json($response);
   
    }
    public function update(Request $request, $id=null)
    {
           
        $update=['expense_id'=>$request->expense_id,'amount'=>$request->amount];
        if ($id) {
            
            // Find the existing expense
            $expense = StudentsExpense::findOrFail($id);
           
            $expense->update($update); // Update the expense
            $response = [
                'status' => 200,
                'msg' => 'Student Updated successfully.'
            ];
        } 

           // Return JSON response
           return response()->json($response);
    }
}
