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
    public function show(Request $request)
    {
        $filters = $request->get('filters', []);

        $query = Student::with(['referredBy', 'course', 'batch', 'department']);

        if (!empty($filters['id'])) {
            $query->where('id', $filters['id']);
        }
        if (!empty($filters['admission_no'])) {
            $query->where('admission_no', 'like', '%' . $filters['admission_no'] . '%');
        }
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (!empty($filters['course'])) {
            $query->whereHas('course', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['course'] . '%');
            });
        }
        if (!empty($filters['batch'])) {
            $query->whereHas('batch', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['batch'] . '%');
            });
        }
        if (!empty($filters['department'])) {
            $query->whereHas('department', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['department'] . '%');
            });
        }
        if (!empty($filters['seat_type'])) {
            $query->where('seat_type', $filters['seat_type']);
        }

        $students = $query->paginate(10);

        $disp = '';
        foreach ($students as $student) {
            $disp .= '<tr>';
            $disp .= '<td>' . $student->id . '</td>';
            $disp .= '<td>' . $student->admission_no . '</td>';
            $disp .= '<td>' . $student->name . '</td>';
            $disp .= '<td>' . $student->course->name . '</td>';
            $disp .= '<td>' . $student->batch->name . '</td>';
            $disp .= '<td>' . $student->department->name . '</td>';
            if($student->seat_type==1) {
                $seatname="Merit Seat";
            } else if($student->seat_type==2) {
                $seatname="Management Seat";
            }
            $disp .= '<td>' . $seatname . '</td>';
            $disp .= '<td>';
            $disp .= '<a class="btn btn-primary" onclick="editModal(this)"
                data-id="' . $student->id . '"
                data-name="' . $student->name . '"
                data-dob="' . $student->dob . '"
                data-contact_number="' . $student->contact_number . '"
                data-contact_person="' . $student->contact_person . '"
                data-student_relation="' . $student->student_relation . '"
                data-seat_type="' . $student->seat_type . '"
                data-donation="' . $student->donation . '"
                data-referred_by="' . $student->referred_by . '"
                data-address="' . $student->address . '"
                data-gender="' . $student->gender . '"
                data-admission_no="' . $student->admission_no . '"
                data-course="' . $student->course_id . '"
                data-batch="' . $student->batch_id . '"
                data-department="' . $student->department_id. '">Edit</a>';
            $disp .= '<form action="' . route('students.destroy', $student) . '" method="POST" style="display:inline;">';
            $disp .= csrf_field();
            $disp .= method_field('DELETE');
            $disp .= '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>';
            $disp .= '</form>';
            $disp .= '</td>';
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

    public function index(Request $request)
    {
        $managementUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'Management');
        })->get();

        $courses = Course::all();
        $batches = Batch::all();
        $departments = Department::all();
        $seatTypes = SeatType::all();
        $students = Student::withSameCourse()->with(['referredBy', 'course', 'batch', 'department'])->paginate(10);
        //$students = Student::with(['referredBy', 'course', 'batch', 'department'])->paginate(10);

        //dd($students);


        return view('students.index', compact('students', 'managementUsers', 'courses', 'batches', 'departments', 'seatTypes'));
    }
    public function loadTable(Request $request)
    {
        $filters = $request->get('filters', []);
        $query = Student::withSameCourse()->with(['referredBy', 'course', 'batch', 'department']);

        if (!empty($filters['id'])) {
            $query->where('id', $filters['id']);
        }
        if (!empty($filters['admission_no'])) {
            $query->where('admission_no', 'like', '%' . $filters['admission_no'] . '%');
        }
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (!empty($filters['course'])) {
            $query->whereHas('course', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['course'] . '%');
            });
        }
        if (!empty($filters['batch'])) {
            $query->whereHas('batch', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['batch'] . '%');
            });
        }
        if (!empty($filters['department'])) {
            $query->whereHas('department', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['department'] . '%');
            });
        }
        if (!empty($filters['seat_type'])) {
            $query->where('seat_type', $filters['seat_type']);
        }

        $students = $query->orderBy('id', 'desc')->paginate(10);

        $disp = '';
        foreach ($students as $student) {
            $disp .= '<tr>';
            // $disp .= '<td>' . $student->id . '</td>';
            $disp .= '<td>' . $student->admission_no . '</td>';
            $disp .= '<td>' . $student->name . '</td>';
            $disp .= '<td>' . $student->course->name . '</td>';
            $disp .= '<td>' . $student->batch->name . '</td>';
            $disp .= '<td>' . $student->department->name . '</td>';
            if($student->seat_type==1) {
                $seatname="Merit Seat";
            } else if($student->seat_type==2) {
                $seatname="Management Seat";
            }
            $disp .= '<td>' . $seatname . '</td>';
            $disp .= '<td>';
            $disp .= '<a class="btn btn-sm btn-primary mr-1" onclick="editModal(this)"
                data-id="' . $student->id . '"
                data-name="' . $student->name . '"
                data-dob="' . $student->dob . '"
                data-contact_number="' . $student->contact_number . '"
                data-contact_person="' . $student->contact_person . '"
                data-student_relation="' . $student->student_relation . '"
                data-seat_type="' . $student->seat_type . '"
                data-donation="' . $student->donation . '"
                data-referred_by="' . $student->referred_by . '"
                data-address="' . $student->address . '"
                data-gender="' . $student->gender . '"
                data-admission_no="' . $student->admission_no . '"
                data-course="' . $student->course_id . '"
                data-batch="' . $student->batch_id . '"
                data-department="' . $student->department_id. '">Edit</a>';
            $disp .= '<form action="' . route('students.destroy', $student) . '" method="POST" style="display:inline;">';
            $disp .= csrf_field();
            $disp .= method_field('DELETE');
            $disp .= '<button type="submit" class="btn btn-sm btn-danger mr-1" onclick="return confirm(\'Are you sure?\')">Delete</button>';
            $disp .= '</form>';
            $disp .= '</td>';
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

    public function checkBatchSeatStatus(Request $request)
    {
        $seatid = $request->seatid;
        $batchid = $request->batchId;
        $course_id = $request->course_id;

        $noOfStudents = Student::where('seat_type', $seatid)
            ->where('course_id', $course_id)
            ->where('batch_id', $batchid)
            ->count();
        $seatTypes = SeatType::where('id', $seatid)->first();
        $batches = Batch::where('id', $batchid)->first();
        $status = '';
        $msg = '';
        $totalseat = '';
        if ($seatid == 1) {
            $totalseat = $batches->merit_seat;
            if ($noOfStudents == $totalseat) {
                $status = 'NotAvailable';
                $msg = 'Seat not Available (' . $noOfStudents . '/' . $totalseat . ')';
            } else {
                $status = 'Available';
                $msg = '::Available seats:' . $totalseat;
            }
        } else if ($seatid == 2) {
            $totalseat = $batches->payment_seat;
            if ($noOfStudents == $totalseat) {
                $status = 'NotAvailable';
                $msg = 'Seat not Available (' . $noOfStudents . '/' . $totalseat . ')';
            } else {
                $status = 'Available';
                $msg = '::Available seats:' . $totalseat;
            }
        }
        $response = [
            'status' => $status,
            'msg' => $msg
        ];

        // Return JSON response
        return response()->json($response);


    }

    public function searchAdmissions(Request $request)
    {
        $query = $request->input('query');
        $admissions = Student::where('admission_no', 'LIKE', "%{$query}%")->get();

        return response()->json($admissions->map(function ($student) {
            return ['id' => $student->id, 'text' => $student->admission_no.' ('.$student->name.')'];
        }));
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
            // 'donation' => 'nullable|numeric',
            // 'referred_by' => 'nullable|exists:users,id',
            'admission_no' => 'required|string|max:255|unique:students,admission_no',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'department_id' => 'required|exists:departments,id',
            'gender' => 'required|string|max:255',
        ]);

        Student::create($request->all());
        $response = [
            'status' => 200,
            'msg' => 'Student created successfully.'
        ];

        // Return JSON response
        return response()->json($response);
        // return redirect()->route('students.index')->with('success', 'Student created successfully.');
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
            // 'donation' => 'nullable|numeric',
            // 'referred_by' => 'nullable|exists:users,id',
            'admission_no' => 'required|string|max:255|unique:students,admission_no,' . $student->id,
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'department_id' => 'required|exists:departments,id',
            'gender' => 'required|string|max:255',

        ]);

        $student->update($request->all());
        $response = [
            'status' => 200,
            'msg' => 'Student Updated successfully.'
        ];

        // Return JSON response
        return response()->json($response);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
