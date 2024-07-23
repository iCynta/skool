@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Employee Expense</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('employee.expenses.update', $employeeExpense->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="voucher_no">Voucher Number</label>
                    <input type="text" class="form-control @error('voucher_no') is-invalid @enderror" id="voucher_no" name="voucher_no" value="{{ old('voucher_no', $employeeExpense->voucher_no) }}" placeholder="Enter voucher number">
                    @error('voucher_no')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="employee_id">Employee</label>
                    <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id">
                        <option value="">Select Employee</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $employeeExpense->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expense_id">Expense Type</label>
                    <select class="form-control @error('expense_id') is-invalid @enderror" id="expense_id" name="expense_id">
                        <option value="">Select Expense Type</option>
                        @foreach ($expenseMasters as $expense)
                            <option value="{{ $expense->id }}" {{ old('expense_id', $employeeExpense->expense_id) == $expense->id ? 'selected' : '' }}>{{ $expense->name }}</option>
                        @endforeach
                    </select>
                    @error('expense_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="created_by">Created By</label>
                    <input type="text" class="form-control @error('created_by') is-invalid @enderror" id="created_by" name="created_by" value="{{ old('created_by', $employeeExpense->created_by) }}" readonly>
                    @error('created_by')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="settled">Settled</label>
                    <select class="form-control @error('settled') is-invalid @enderror" id="settled" name="settled">
                        <option value="0" {{ old('settled', $employeeExpense->settled) == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('settled', $employeeExpense->settled) == '1' ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('settled')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('employee.expenses.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@endsection
