@extends('layouts.dashboard')

@section('title', 'Employee Expenses')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Employee Expense Master</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee Expenses</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Filter Options</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employee-expenses.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="employee_id">Employee</label>
                                        <select class="form-control" id="employee_id" name="employee_id">
                                            <option value="">All Employees</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="settled">Settled</label>
                                        <select class="form-control" id="settled" name="settled">
                                            <option value="">All</option>
                                            <option value="0" {{ request('settled') === 0 ? 'selected' : '' }}>Not Settled</option>
                                            <option value="1" {{ request('settled') === 1 ? 'selected' : '' }}>Settled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('employee-expenses.index') }}" class="btn btn-default">Clear</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Filter Section -->

                <!-- Expense List -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Expense List</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voucher Number</th>
                                    <th>Employee</th>
                                    <th>Expense Type</th>
                                    <th>Settled</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employeeExpenses as $expense)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $expense->voucher_no }}</td>
                                        <td>{{ $expense->employee->name }}</td>
                                        <td>{{ $expense->expenseMaster->name }}</td>
                                        <td>{{ $expense->settled ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <a href="{{ route('employee-expenses.show', $expense->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('employee-expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <!-- Add delete button if needed -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <div class="float-right">
                            {{ $employeeExpenses->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
                <!-- End Expense List -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
