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
use Illuminate\Support\Facades\Auth;

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
    public function create(Request $request)
    {
        try {
            $created_by = (int) Auth::user()->id;
    
            // Update the validation rule if the table name is incorrect
            $validatedData = $request->validate([
                'admission_no' => 'required|integer|exists:students,id',
                'expense_id' => 'required|integer|exists:expenses,id', // Update to match the correct table name
                'amount' => 'required|numeric|min:0'
            ]);
    
            $data = [
                'student_id' => $validatedData['admission_no'],
                'expense_id' => $validatedData['expense_id'],
                'amount' => $validatedData['amount'],
                'created_by' => $created_by
            ];
            dd($data);
    
            // Create the expense record
            $studentExpense = StudentsExpense::create($data);
            
            // Generate and update the receipt number
            $receipt_no = 'REC-' . str_pad($studentExpense->id, 6, '0', STR_PAD_LEFT);
            $studentExpense->update(['reciept_no' => $receipt_no]);
    
            // Prepare and return the response
            $response = [
                'status' => 200,
                'msg' => 'Expense recorded successfully.',
                'receipt_no' => $receipt_no
            ];
    
            return response()->json($response);
    
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database Query Error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'msg' => 'Database query error.', 'error' => $e->getMessage()]);
        } catch (\Exception $e) {
            \Log::error('General Error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'msg' => 'Internal server error.', 'error' => $e->getMessage()]);
        }
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
