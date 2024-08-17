<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Department;
use App\Models\SeatType;
use App\Models\StudentsExpense;
use App\Models\StudentsExpenseMasterModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\StudentsExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StudentReportController extends Controller
{
    /**
     * Display a listing of the student report.
     */
    public function index(Request $request)
    {

        // Initialize the query
        $query = Student::query();

        // Apply filters if present
        if ( Auth::user()->roles->first()->name === 'Management' && $request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        } else {
            $query->where('course_id', Auth::user()->course_id);
        }
    
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }
    
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
    
        if ($request->filled('seat_type_id')) {
            $query->where('seat_type', $request->seat_type_id);
        }
    
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = Carbon::createFromFormat('d-m-Y', $request->from_date)->startOfDay();
            $toDate = Carbon::createFromFormat('d-m-Y', $request->to_date)->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($request->filled('from_date')) {
            $fromDate = Carbon::createFromFormat('d-m-Y', $request->from_date)->startOfDay();
            $query->where('created_at', '>=', $fromDate);
        } elseif ($request->filled('to_date')) {
            $toDate = Carbon::createFromFormat('d-m-Y', $request->to_date)->endOfDay();
            $query->where('created_at', '<=', $toDate);
        }
    
        $students = $query->orderBy('id', 'DESC')->paginate(10);
    
        // Fetch data for filters by checking the role of the logged-in user
        if(Auth::user()->roles->first()->name === 'Management'){
            $courses = Course::all();
            $batches = Batch::all();
            $departments = Department::all();
        } else {
            $courses = Course::where('id', Auth::user()->course_id)->get();
            $batches = Batch::where('course_id', Auth::user()->course_id)->get();
            $departments = Department::where('course_id', Auth::user()->course_id)->get();
        }     
    
        $seatTypes = SeatType::all(); 
        $seatTypesforTable = SeatType::all()->pluck('name', 'id')->toArray();
    
        // Get additional student details
        $studentDetails = $this->getStudentDetails();

    
     
        return view('report.students_report', compact('students', 'courses', 'batches', 'departments', 'seatTypes', 'seatTypesforTable', 'studentDetails'));
    }
    
    private function getStudentDetails()
    {
        $studentDetails = [];
        $students = Student::all(); // Fetch all students

        foreach ($students as $student) {
            $batch = Batch::where('id', $student->batch_id)->first();
            $course = Course::where('id', $student->course_id)->first();
            $department = Department::where('id', $student->department_id)->first();

            if (!$batch || !$course || !$department) {
                continue; // Skip if any related record is not found
            }

            // Calculate financial details
            $totalFees = $batch->tution_fee; // Total fees
            $amountPaid = StudentsExpense::where('student_id', $student->id)
                ->where('expense_id', 1)
                ->sum('amount'); // Amount paid
            $balance = $totalFees - $amountPaid;
            $totalMonths = $batch->course_tenure; // Total months for payment
            $monthsPaid = $this->calculateMonthsPaid($totalFees, $amountPaid, $totalMonths);
            $donationPaid = StudentsExpense::where('student_id', $student->id)
                ->where('expense_id', 2)
                ->sum('amount'); // Donation paid

            // Prepare student data
            $studentDetails[$student->id] = [
                'batch' => $batch->name,
                'name' => $student->name,
                'course' => $course->name,
                'department' => $department->name,
                'dob' => $student->dob,
                'coursefee' => $batch->tution_fee . ' INR',
                'tenure' => $batch->course_tenure . ' Months',
                'paidinst' => $monthsPaid,
                'TotalamtPaid' => $amountPaid . ' INR',
                'balancefee' => $balance . ' INR',
                'donation' => $donationPaid . ' INR'
            ];
        }

        return $studentDetails;
    }

    // Example private method to calculate months paid
    private function calculateMonthsPaid($totalFees, $amountPaid, $totalMonths)
    {
        // Logic to calculate the number of months paid
        // This is a placeholder; adjust as necessary for your application
        $paidPerMonth = $totalFees / $totalMonths;
        return intval($amountPaid / $paidPerMonth);
    }
    public function export(Request $request)
{
    $filters = $request->only(['course_id', 'batch_id', 'department_id', 'seat_type_id', 'from_date', 'to_date']);
    return Excel::download(new StudentsExport($filters), 'students.xlsx');
}
}
