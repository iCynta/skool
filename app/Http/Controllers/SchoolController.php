<?php

namespace App\Http\Controllers;

use App\Models\school;
use Illuminate\Http\Request;

//use Spatie\Translatable\HasTranslations;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::all(); // Fetch all schools from the database
        return view('schools.index', compact('schools')); // Pass schools to the view
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

    public function getSchools(Request $request)
    {
        if ($request->ajax()) {
            $schools = School::all(); // Select all columns (adjust as needed)
    
            $datatables = Datatables::of($schools);
    
            // Apply filtering based on request parameters (optional)
            if ($request->has('search')) {
                $datatables->filter(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('code', 'like', '%' . $request->get('search') . '%');
                });
            }
    
            // Apply sorting based on request parameters (optional)
            if ($request->has('order')) {
                $datatables->order(function ($query) use ($request) {
                    $order = $request->get('order');
                    $column = $order[0]['column'];
                    $dir = $order[0]['dir'];
                    $query->orderBy($column, $dir);
                });
            }
    
            // Apply pagination based on request parameters (optional)
            // You might need to adjust this based on your DataTables configuration
            $datatables->skip($request->get('start'))
                       ->take($request->get('length'));
    
            return $datatables->make(true); // Set true for server-side processing
        }
    
        return view('schools.index'); // Handle regular GET requests (optional)
    }
    
}
