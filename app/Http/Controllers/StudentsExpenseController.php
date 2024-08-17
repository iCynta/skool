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
        $monthlabel=($monthsPaid>1)?'Months':'Month';
        $response = [
            'status' => 200,
            'batch' =>$batch->name,
            'name' =>$students->name,
            'course'=>$Course->name,
            'department'=>$Department->name,
            'dob'=>$students->dob,
            'coursefee'=>$batch->tution_fee.' INR',
            'tenuture'=>$batch->course_tenure.' Months',
            'paidinst'=>$monthsPaid.' '.$monthlabel,
            'TotalamtPaid'=>$amountPaid.' INR',
            'balancefee'=>$balance.' INR',
            'donation'=>$donationPaid.' INR',
            'donationFeesAgreed'=>$students->donation.' INR'
        ];
    
        // Return JSON response
        return response()->json($response);

    }
    public function loadExpenseReciepts(Request $request)
    {
        // Adjust the pagination size as needed, e.g., 10 items per page
        $students = StudentsExpense::where('student_id', $request->admission_no)
        ->orderBy('created_at', 'desc') // Order by 'created_at' column in descending order
        ->paginate(5);
    
        $disp = ''; // Initialize $disp to avoid undefined variable notice
        
        foreach ($students as $student) {
            $std = StudentsExpenseMasterModel::where('id', $student->expense_id)->first();
            $disp .= '<tr>';
            // $disp .= '<td>' . $student->id . '</td>';
            $disp .= '<td>' . $student->created_at . '</td>';
            $disp .= '<td>' . $std->expense_name . '</td>';
            $disp .= '<td><a target="_blank" href="' . route('reciepts', ['id' => $student->reciept_no]) . '">' . $student->reciept_no . '</a></td>';
            $disp .= '<td>' . $student->amount . '</td>';
            $disp .= '<td><button type="button" class="btn btn-danger" data-id="' . $student->id . '" data-expense_name="' . $student->expense_id . '" data-amount="' . $student->amount . '" onclick="editExpense(this)">Edit</button></td>';
            $disp .= '</tr>';
        }
    
        $paginate = $students->links('vendor.pagination.bootstrap-4')->toHtml();
    
        $response = [
            'status' => 200,
            'data' => $disp,
            'links' => $paginate
        ];
        return response()->json($response);
    }
    
    public function create(Request $request)
    {
        try {
            $created_by = (int) Auth::user()->id;
    
            // Directly use the request data without validation
            $data = [
                'student_id' => $request->input('admission_no'),
                'expense_id' => $request->input('expense_id'),
                'amount' => $request->input('amount'),
                'created_by' => $created_by
            ];
    
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
        $stdetails=StudentsExpense::where('id', $id);
        dd($stdetails);
        $studentsData = $this->searchStudentsDetailsInternal($request->input('admission_no'));
        $totalFeesRequired=$studentsData['coursefee'];
        $totalFeesRequired=$studentsData['coursefee'];

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


    public function searchStudentsDetailsInternal($addmissno)
    {
        $students=Student::where('id',$addmissno)->first();
     
        $batch=Batch::where('id',$students->batch_id)->first();
        $Course=Course::where('id',$students->course_id)->first();
        $Department=Department::where('id',$students->department_id)->first();
      
        $totalInstallments=$batch->course_tenure;
        $totalFees = $batch->tution_fee; // Total fees
        $amountPaid = StudentsExpense::where('student_id', $addmissno)
        ->where('expense_id', 1)
        ->sum('amount'); // Amount paid
        $totalMonths = $batch->course_tenure; // Total months for payment
        $balance=$totalFees-$amountPaid;
        $monthsPaid = $this->calculateMonthsPaid($totalFees, $amountPaid, $totalMonths);
        $donationPaid = StudentsExpense::where('student_id', $addmissno)
        ->where('expense_id', 2)
        ->sum('amount'); // Amount paid
        $response = [
            'status' => 200,
            'batch' =>$batch->name,
            'name' =>$students->name,
            'course'=>$Course->name,
            'department'=>$Department->name,
            'dob'=>$students->dob,
            'coursefee'=>$batch->tution_fee,
            'tenuture'=>$batch->course_tenure,
            'paidinst'=>$monthsPaid,
            'TotalamtPaid'=>$amountPaid,
            'balancefee'=>$balance,
            'donation'=>$donationPaid,
            'donationFeesAgreed'=>$students->donation
        ];
    
        // Return JSON response
        return $response;

    }


    public function checkStudentFeesExceeded(Request $request)
    {
        $expense_id=$request->expense_id;
        $amount=$request->amount;
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
      
        $exceeded=0;
        $msg='Not Exceeded';
     
        if($expense_id==1)
        {
            $outstandingAmount=$amount+$balance;
            if($balance==0)
            {
                $exceeded=1;  
                $msg='Full Fees already paid';
            }
            else if($amount==$balance)
            {
                $exceeded=0;  
                $msg='Not Exceeded';
            }
            else if($outstandingAmount>$totalFees)
            {
                $exceeded=1;  
                $msg='Fees Exceeded ! Please Enter Vaid Amount';
            }
            else if($outstandingAmount<$totalFees)
            {
                $exceeded=0;  
                $msg='Not Exceeded';
            }
            $response = [
             'feesExeeded' => $exceeded,
             'msg'=>$msg
            ];
        }
        else if($expense_id==2)
        {
            $balanceDonation=$students->donation-$donationPaid;
            $outstandingDonation=$amount+$balanceDonation;
            if($balanceDonation==0)
            {
                $exceeded=1;  
                $msg='Full Donation already paid';
            }
            else if($amount==$balanceDonation)
            {
                $exceeded=0;  
                $msg='Not Exceeded';
            }
            else if($outstandingDonation>$students->donation)
            {
                $exceeded=1;  
                $msg='Donation Exceeded ! Please Enter Vaid Amount';
            }
            else if($outstandingDonation<$students->donation)
            {
                $exceeded=0;  
                $msg='Not Exceeded';
            }
            $response = [
             'feesExeeded' => $exceeded,
             'msg'=>$msg
            ];
        }
  
     // Return JSON response
        return $response;

    }
}
