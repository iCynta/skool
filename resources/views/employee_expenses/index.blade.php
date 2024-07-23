@extends('layouts.dashboard')

@section('title', 'Employee Expenses')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Expense List</h1>
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


                <!-- Expense List -->
                <div class="card mt-3">
                    <div class="card-header">
                        <a href="{{route('expenses.create')}}" class="btn btn-md btn-success float-right"> Add</a>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <thead>
                                <tr class="bg-dark">
                                    <th>#</th>
                                    <th>Voucher Number</th>
                                    <th>Employee</th>
                                    <th>Expense Type</th>
                                    <th>Settled</th>
                                    <th>Actions</th>
                                </tr>
                                <tr class="bg-info">
                                    <th colspan="6">
                                        <form action="{{ route('expenses.index') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">

                                                        <select class="form-control form-control-sm" id="employee_id"
                                                            name="employee_id">
                                                            <option value="">All Employees</option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    
                                                        <select class="form-control form-control-sm" id="settled" name="settled">
                                                            <option value="">All</option>
                                                            <option value="0" {{ request('settled') === 0 ? 'selected' : '' }}>Not Settled</option>
                                                            <option value="1" {{ request('settled') === 1 ? 'selected' : '' }}>Settled</option>
                                                        </select>
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                                                                           
                                                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                                        <a href="{{ route('expenses.index') }}"
                                                            class="btn btn-sm btn-default">Clear</a>
                                                    
                                                </div>
                                            </div>
                                        </form>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($expenses as $expense)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $expense->voucher_no }}</td>
                                        <td>{{ $expense->employee->name }}</td>
                                        <td>{{ $expense->expenseMaster->name }}</td>
                                        <td>{{ $expense->settled ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <a href="{{ route('expenses.show', $expense->id) }}"
                                                class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('expenses.edit', $expense->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
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
                            {{ $expenses->withQueryString()->links('vendor.pagination.bootstrap-4') }}
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