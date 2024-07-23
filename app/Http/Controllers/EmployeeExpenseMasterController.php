<?php

namespace App\Http\Controllers;

use App\Models\EmployeeExpenseMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeExpenseMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseMasters = EmployeeExpenseMaster::all();
        return view('employee_expense_masters.index', compact('expenseMasters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee_expense_masters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        EmployeeExpenseMaster::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('employee_expense_masters.index')
            ->with('success', 'Expense Master created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeExpenseMaster $employeeExpenseMaster)
    {
        return view('employee_expense_masters.show', compact('employeeExpenseMaster'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeExpenseMaster $employeeExpenseMaster)
    {
        return view('employee_expense_masters.edit', compact('employeeExpenseMaster'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeExpenseMaster $employeeExpenseMaster)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employeeExpenseMaster->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('employee_expense_masters.index')
            ->with('success', 'Expense Master updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeExpenseMaster $employeeExpenseMaster)
    {
        $employeeExpenseMaster->delete();
        return redirect()->route('employee_expense_masters.index')
            ->with('success', 'Expense Master deleted successfully.');
    }
}
