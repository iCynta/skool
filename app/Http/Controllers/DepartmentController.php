<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\DataTables\DepartmentsDataTable;
use App\Models\Course;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentsDataTable $dataTable)
    {
        return $dataTable->render('department.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('department.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Fetch the course code using the course ID
        $course = Course::find($request->input('course_id'));
        if (!$course) {
            return redirect()->back()->with('error', 'Invalid course selected');
        }
        // Generate a batch code based on the course code
        $departmentCode = $course->code . '-' . substr($request->name, 0, 3);

        // Create the batch with the generated code
        $batch = Department::create([
            'name' => $request->input('name'),
            'course_id' => $request->input('course_id'),
            'code' => $departmentCode,
        ]);
        
        if(!$batch->id){
            return redirect()->route('department.list')->with('error', 'Department cannot be created!');
        }

        return redirect()->route('department.list')->with('success', 'Department created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
