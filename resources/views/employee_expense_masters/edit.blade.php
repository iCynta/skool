@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Expense Master</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('expense-masters.update', $employeeExpenseMaster->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $employeeExpenseMaster->name) }}" placeholder="Enter name">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="1" {{ old('status', $employeeExpenseMaster->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $employeeExpenseMaster->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('expense-masters.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@endsection
