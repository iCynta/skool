<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Department;
use App\Models\SeatType;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['referredBy', 'course', 'batch', 'department'])->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $managementUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'Management');
        })->get();
        $courses = Course::all();
        $batches = Batch::all();
        $departments = Department::all();
        $seatTypes = SeatType::all();
        return view('students.create', compact('managementUsers', 'courses', 'batches', 'departments', 'seatTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'contact_number' => 'nullable|string|max:15',
            'contact_person' => 'nullable|string|max:255',
            'student_relation' => 'nullable|string|max:255',
            'seat_type' => 'required|string|max:255',
            'donation' => 'nullable|numeric',
            'referred_by' => 'nullable|exists:users,id',
            'admission_no' => 'required|string|max:255|unique:students,admission_no',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $users = User::all();
        $courses = Course::all();
        $batches = Batch::all();
        $departments = Department::all();
        return view('students.edit', compact('student', 'users', 'courses', 'batches', 'departments'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'contact_number' => 'nullable|string|max:15',
            'contact_person' => 'nullable|string|max:255',
            'student_relation' => 'nullable|string|max:255',
            'seat_type' => 'required|string|max:255',
            'donation' => 'nullable|numeric',
            'referred_by' => 'nullable|exists:users,id',
            'admission_no' => 'required|string|max:255|unique:students,admission_no,' . $student->id,
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
