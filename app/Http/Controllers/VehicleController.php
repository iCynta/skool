<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleExpense;
use App\Models\VehicleExpenseMaster;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //list
        $vehicles = Vehicle::all();
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
                'fuel' => 'string|max:10',
                'description' => 'max:100'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Vehicle::create($request->all());
        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try
        {
            $vehicle = Vehicle::findOrFail($id);
            return view('vehicles.view', compact('vehicle'));
        } catch (ModelNotFoundException $e) 
        {
            return redirect()->back()->with('error', 'Vehicle not found.');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try
        {
            $vehicle = Vehicle::findOrFail($id);
            return view('vehicles.edit', compact('vehicle'));
        } catch (ModelNotFoundException $e) 
        {
            return redirect()->back()->with('error', 'Vehicle not found.');
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,'.$id,
                'fuel' => 'string|max:10',
                'description' => 'max:100'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try
        {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($request->all());
            return redirect()->route('vehicles.show',['vehicle'=>$vehicle->id])->with('success','Vehicle details successfully updated');
        } catch (ModelNotFoundException $e)
        {
            return redirect()->back()->with('error', 'Vehicle not found');
        }
                
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }

    public function CreateExpense(Request $request)
    {
        $vehicleExpenseMasters = VehicleExpenseMaster::all();
        $vehicles = Vehicle::all();
        return view('vehicles.create_expense', compact('vehicleExpenseMasters', 'vehicles'));
    }

    public function AddVehicleExpence(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'vehicle_id' => 'required|string|max:20|exists:vehicles,id',
                'expense_id' => 'required|integer|exists:vehicle_expense_master,id',
                'amount' => 'required|numeric|min:1',
                'fuel' => 'string|max:10',
                'description' => 'max:100'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try
        {
            $expense = $request->all();
            $expense['created_by'] = Auth()->user()->id;
            VehicleExpense::create($expense);
            return redirect()->route('vehicles.show',['vehicle'=>$request->vehicle_id])->with('success','Expense successfully added');
        } catch (ModelNotFoundException $e)
        {
            return redirect()->back()->with('error', 'Expense can not record');
        }
    }
}
