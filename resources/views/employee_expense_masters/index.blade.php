@extends('layouts.dashboard')

@section('title', 'Expense Masters')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Expense Masters</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Expense Masters</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expense Masters List</h3>
                        <div class="card-tools">
                            <a href="{{ route('employee_expense_masters.create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('partials.message_board')
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenseMasters as $expenseMaster)
                                    <tr>
                                        <td>{{ $expenseMaster->name }}</td>
                                        <td>{{ $expenseMaster->status ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('employee_expense_masters.show', $expenseMaster->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('employee_expense_masters.edit', $expenseMaster->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('employee_expense_masters.destroy', $expenseMaster->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No expense masters found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
