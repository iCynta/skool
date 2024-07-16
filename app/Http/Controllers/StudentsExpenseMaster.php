<?php

namespace App\Http\Controllers;
use App\Models\StudentsExpenseMasterModel;
use Illuminate\Http\Request;

class StudentsExpenseMaster extends Controller
{
  
    public function loadStudentsExpense(Request $request)
    {
        $StudentsExpenseMasterModel = StudentsExpenseMasterModel::paginate(10); // Adjust items per page as needed
    
        $disp = '';
        $incr = 1;
        foreach ($StudentsExpenseMasterModel as $row) {
            $disp .= '<tr>';
            $disp .= '<td>' . $row['id'] . '</td>';
            $disp .= '<td>' . $row['expense_name'] . '</td>';
            $disp .= '<td>' . $row['created_at'] . '</td>';
            $disp .= '<td><a class="btn btn-sm btn-primary" onclick="editModal(this)" data-status="'.$row['status'].'" data-id="'.$row['id'].'" data-expense_name="'.$row['expense_name'].'" data-status="'.$row['status'].'">edit</a></td>';
            $disp .= '</tr>';
            $incr++;
        }
    
        // Prepare pagination links
        $paginate = $StudentsExpenseMasterModel->links('vendor.pagination.bootstrap-4')->toHtml();
    
        $response = [
            'status' => 200,
            'data' => $disp,
            'links' => $paginate
        ];
    
        // Return JSON response
        return response()->json($response);
    }
    public function save(Request $request, $id = null)
    {
        // Validate the request data
   
    
        $request->validate([
            'expense_name' => 'required|string|max:255',
            // 'status' => 'required|numeric'
        ]);

        // Check if we are updating an existing expense or creating a new one
        
        if ($id) {
            
            // Find the existing expense
            $expense = StudentsExpenseMasterModel::findOrFail($id);
           
            $expense->update($request->all()); // Update the expense
            $message = 'Expense updated successfully!';
        } else {
            // Create a new expense
            StudentsExpenseMasterModel::create($request->all());
            $message = 'Expense created successfully!';
        }
        $response = [
            'status' => 200,
            'mesg' => $message,
  
        ];
    
        // Return JSON response
        return response()->json($response);
    }
    

}
