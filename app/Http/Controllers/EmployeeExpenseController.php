<?php
namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\EmployeeExpense;
use App\Models\EmployeeExpenseMaster;
use Illuminate\Http\Request;
use PDF;


class EmployeeExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = User::all();
        $query = EmployeeExpense::with('employee', 'expenseMaster');

        // Apply filters
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        if ($request->filled('settled')) {
            $query->where('settled', $request->settled);
        }

        // Retrieve filtered expenses
        $expenses = $query->orderBy('id','desc')->paginate(10);

        // Return view with filtered expenses
        return view('employee_expenses.index', compact('expenses', 'employees'));
    }

    public function create()
    {
        $employees = User::all();
        $expenseTypes = EmployeeExpenseMaster::all();
        return view('employee_expenses.create', compact('employees', 'expenseTypes'));
    }

    public function store(Request $request)
    {
 
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'expense_id' => 'required|exists:employee_expense_masters,id',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'description' => 'nullable|string',
            //'voucher_no' => 'required|string|max:20|unique:employee_expenses,voucher_no',
            ///'created_by' => 'required|exists:users,id',
            // 'settled' => 'required|boolean',
        ]);
        
     
        try {
            $expense = new EmployeeExpense();
            
            $expense->employee_id = $validatedData['employee_id'];
            $expense->expense_id = $validatedData['expense_id'];
            $expense->description = $validatedData['description'];
            $expense->created_by = auth()->id();
            $expense->amount = $validatedData['amount'];
            $expense->settled = 0;
            $expense->save();
            $voucher_no = 'VOU-' . str_pad($expense->id, 6, '0', STR_PAD_LEFT);
            $expense->update(['voucher_no' => $voucher_no]);

            return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
        } catch (\Exception $e) {
            \Log::error('Error saving EmployeeExpense: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while saving the expense. Please try again.']);
        }
    }
    

    public function show($id)
    {
        $expense = EmployeeExpense::with('employee', 'expenseMaster', 'createdBy')->findOrFail($id);
        return view('employee_expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = EmployeeExpense::findOrFail($id);
        $authUser = Auth::user();

        if ($authUser->role->name == 'Management') {
            // Get all users
            $users = User::all();
        } else {
            // Get users based on the same course as the authenticated user
            $users = User::where('course_id', $authUser->course_id)->get();
        }
        $expenseMasters = EmployeeExpenseMaster::all();
        return view('employee_expenses.edit', compact('expense', 'employees', 'expenseMasters'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'expense_id' => 'required|exists:employee_expense_masters,id',
            'voucher_no' => 'required|string|max:20|unique:employee_expenses,voucher_no,' . $id,
            'created_by' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'settled' => 'required|boolean',
        ]);

        $expense = EmployeeExpense::findOrFail($id);
        $expense->employee_id = $validatedData['employee_id'];
        $expense->expense_id = $validatedData['expense_id'];
        $expense->voucher_no = $validatedData['voucher_no'];
        $expense->description = $validatedData['description'];
        $expense->created_by = $validatedData['created_by'];
        $expense->settled = $validatedData['settled'];
        $expense->save();

        return redirect()->route('employee_expenses.index')->with('success', 'Expense updated successfully!');
    }

    public function destroy($id)
    {
        $expense = EmployeeExpense::findOrFail($id);
        $expense->delete();

        return redirect()->route('employee_expenses.index')->with('success', 'Expense deleted successfully!');
    }

    public function printExpenseVoucher($voucher)
    {
        $expense = EmployeeExpense::where('voucher_no', $voucher)->with(['employee', 'expenseMaster', 'createdBy'])->firstOrFail();
        $school = School::find(1);

        $pdf = PDF::loadView('employee_expenses.voucher-print', compact('expense','school'));
        return $pdf->stream('Vouch-'.$expense->voucher_no.'.pdf');

    }
}
