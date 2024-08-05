<?php
namespace App\Exports;

use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Department;
use App\Models\SeatType;
use App\Models\StudentsExpense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Student::query();

        // Apply filters from the request
        if (isset($this->filters['course_id'])) {
            $query->where('course_id', $this->filters['course_id']);
        }
        if (isset($this->filters['batch_id'])) {
            $query->where('batch_id', $this->filters['batch_id']);
        }
        if (isset($this->filters['department_id'])) {
            $query->where('department_id', $this->filters['department_id']);
        }
        if (isset($this->filters['seat_type_id'])) {
            $query->where('seat_type', $this->filters['seat_type_id']);
        }
        if (isset($this->filters['from_date']) && isset($this->filters['to_date'])) {
            $fromDate = Carbon::createFromFormat('d-m-Y', $this->filters['from_date'])->startOfDay();
            $toDate = Carbon::createFromFormat('d-m-Y', $this->filters['to_date'])->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif (isset($this->filters['from_date'])) {
            $fromDate = Carbon::createFromFormat('d-m-Y', $this->filters['from_date'])->startOfDay();
            $query->where('created_at', '>=', $fromDate);
        } elseif (isset($this->filters['to_date'])) {
            $toDate = Carbon::createFromFormat('d-m-Y', $this->filters['to_date'])->endOfDay();
            $query->where('created_at', '<=', $toDate);
        }

        $students = $query->get();

        // Get student details
        $studentDetails = $this->getStudentDetails($students);

        // Convert data into a collection format suitable for export
        return collect($studentDetails);
    }

    protected function getStudentDetails($students)
    {
        $studentDetails = [];
        foreach ($students as $student) {
            $batch = $student->batch;
            $course = $student->course;
            $department = $student->department;

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
            $studentDetails[] = [
                $student->id,
                $student->name,
                $course->name,
                $batch->name,
                $department->name,
                $student->seat_type,
                $donationPaid . ' INR',
                $amountPaid . ' INR',
                $balance . ' INR',
                $student->created_at->format('d-m-Y'),
            ];
        }

        return $studentDetails;
    }

    protected function calculateMonthsPaid($totalFees, $amountPaid, $totalMonths)
    {
        $paidPerMonth = $totalFees / $totalMonths;
        return intval($amountPaid / $paidPerMonth);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Course',
            'Batch',
            'Department',
            'Seat Type',
            'Donation Paid',
            'Fees Paid',
            'Balance Fees',
            'Created At',
        ];
    }
}

