<?php

namespace App\Http\Controllers;

use App\Models\school;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\SchoolsDataTable;


class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SchoolsDataTable $dataTable)
    {
        return $dataTable->render('schools.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:schools,code|max:10',
            'affiliation_no' => 'nullable|string|max:10',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:schools,email',
            'address' => 'required|string',
            'logo' => 'nullable|string', // Optional: Validate image file properties if applicable
        ]);

        $school = School::create($request->all());

        return redirect()->route('schools.index')->with('success', 'School created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(school $school)
    {
        return view('schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(school $school)
    {
        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:schools,code,'.$school->id, // Update validation for unique code
            'affiliation_no' => 'nullable|string|max:10',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:schools,email,'.$school->id, // Update validation for unique email
            'address' => 'required|string',
            'logo' => 'nullable|string', // Optional: Validate image file properties if applicable
        ]);

        $school->update($request->all()); // Update the school model with new data

        return redirect()->route('schools.index')->with('success', 'School updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(school $school)
    {
        //
    }

    public function getSchools(SchoolsDataTable $dataTable)
    {
        
        return $dataTable->render('schools.index');
    }
    
}
