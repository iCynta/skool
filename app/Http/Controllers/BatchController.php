<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Batch;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\BatchesDataTable;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BatchesDataTable $dataTable)
    {
        return $dataTable->render('batch.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('batch.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'merit_seat' => 'required|integer',
            'payment_seat' => 'required|integer',
            'tution_fee' => 'required|numeric',
            'course_tenure' => 'required|numeric'
        ]);

        // Fetch the course code using the course ID
        $course = Course::find($request->input('course_id'));
        if (!$course) {
            return redirect()->back()->with('error', 'Invalid course selected');
        }

        // Extract start and end dates
        $startDate = Carbon::parse($request->input('start_date'));

        // Extract years from start and end dates
        $startYear = $startDate->year;
        $course_tenure = ceil(intval($request->input('course_tenure')) / 12);
        $endYear = $startYear + ($course_tenure < 1 ? 1 : $course_tenure); // If the course tenure is less than 1 year
        // Generate the batch code
        $batchCode = $course->code . '-' . $startYear . '-' . $endYear;

        // Create the batch with the generated code
        $batch = new Batch();
        $batch->code = $batchCode;
        $batch->course_id = $course->id;
        $batch->name = $request->input('name');
        $batch->merit_seat = intval($request->input('merit_seat'));
        $batch->payment_seat = intval($request->input('payment_seat'));
        $batch->tution_fee = $request->input('tution_fee');
        $batch->course_tenure = intval($request->input('course_tenure'));
        $batch->start_date = $startDate;

        $batch->save();
        
        if(!$batch->id){
            return redirect()->route('batch.list')->with('error', 'Batch cannot be created!');
        }

        return redirect()->route('batch.list')->with('success', 'Batch created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(batch $batch)
    {
        //
    }
}
