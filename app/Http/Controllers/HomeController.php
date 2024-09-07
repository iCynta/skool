<?php

namespace App\Http\Controllers;

use App\Models\VehicleExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Get the date range from the request, or use the start and end of the current month as default
        $dateFrom = $request->input('date_from') ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->input('date_to') ?? now()->endOfMonth()->format('Y-m-d');
        $chartData = $this->showExpenseChart($dateFrom, $dateTo);
        $expenses = $this->showVehicleExpensesGraph($dateFrom, $dateTo);
        return view('dashboard', compact('chartData','expenses'));
    }

    public function showExpenseChart($dateFrom, $dateTo)
    {
        // Query to get all expense masters and their total expenses in the given date range
        $expenses = DB::table('employee_expense_masters')
            ->leftJoin('employee_expenses', function($join) use ($dateFrom, $dateTo) {
                $join->on('employee_expense_masters.id', '=', 'employee_expenses.expense_id')
                    ->whereBetween('employee_expenses.created_at', [$dateFrom, $dateTo]);
            })
            ->select(
                'employee_expense_masters.name', // Expense master name
                DB::raw('COALESCE(SUM(employee_expenses.amount), 0) as total_amount') // Total amount spent or 0 if no expenses
            )
            ->groupBy('employee_expense_masters.name') // Group by the name of the expense master
            ->get();

        // Prepare data for the chart
        $chartData = [
            'labels' => [],
            'data' => [],
        ];

        // Loop through expenses and add to chart data
        foreach ($expenses as $expense) {
            $chartData['labels'][] = $expense->name; // Set the expense master name as the label
            $chartData['data'][] = $expense->total_amount; // Set the total amount spent (or 0) as the data
        }
        // Return the view with the chart data
        return $chartData;
    }

    public function showVehicleExpensesGraph($dateFrom, $dateTo)
    {
        $expenses = VehicleExpense::select(
            'vehicles.plate_number',
            'vehicle_expense_master.name as expense_type',
            DB::raw('SUM(vehicle_expenses.amount) as total_amount')
        )
        ->join('vehicles', 'vehicles.id', '=', 'vehicle_expenses.vehicle_id')
        ->join('vehicle_expense_master', 'vehicle_expense_master.id', '=', 'vehicle_expenses.expense_id')
        ->whereBetween('vehicle_expenses.created_at', [$dateFrom, $dateTo])
        ->groupBy('vehicles.plate_number', 'vehicle_expense_master.name')
        ->get();

        return $expenses;
    }


}
