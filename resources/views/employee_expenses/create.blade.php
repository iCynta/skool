@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Employee Expenses</li>
                    <li class="breadcrumb-item active">New Expense</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content card">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Message Board -->
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        @include('partials.message_board')
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Add Expense</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('employee.expense.add') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employee_id">Employee</label>
                                    <select class="form-control" name="employee_id" id="employee_id">
                                        <option value="">Select Employee</option>
                                        @forelse($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @empty
                                            <option value="">No Employees Found</option>
                                        @endforelse
                                    </select>
                                    @error('employee_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expense_type">Expense Type</label>
                                    <select class="form-control" name="expense_id" id="expense_id">
                                        <option value="">Select Expense Type</option>
                                        @forelse($expenseTypes as $expense)
                                            <option value="{{ $expense->id }}">{{ $expense->name }}</option>
                                        @empty
                                            <option value="">No Expense Types Found</option>
                                        @endforelse
                                    </select>
                                    @error('expense_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" name="amount" id="amount" class="form-control" min="0"/>
                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
