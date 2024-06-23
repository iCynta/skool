

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Departments</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Students</li>
                    <li class="breadcrumb-item active"><a href="#">New</a></li>
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
        <div class="container mt-2 pb-2">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Message Board -->
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @include('partials.message_board')
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-lg btn-success mr-2" href="{{ route('students.create') }}">Add</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-md-table-striped table-bordered mt-3">
        <thead class="bag-dark">
            <tr>
                <th>Si No:</th>
                <th>Admission No</th>
                <th>Name</th>
                <th>Course</th>
                <th>Batch</th>
                <th>Department</th>
                <th>Seat Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $student->admission_no }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->course->name }}</td>
                    <td>{{ $student->batch->name }}</td>
                    <td>{{ $student->department->name }}</td>
                    <td>{{ $student->seat_type }}</td>  
                    <td>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection




