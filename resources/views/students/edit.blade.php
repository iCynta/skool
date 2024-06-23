
@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Employee Master</li>
                    <li class="breadcrumb-item">Employee</li>
                    <li class="breadcrumb-item active">update</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="container">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Update Employee Details</h3>
            </div>
                <!-- /.card-header -->
            <div class="card-body">
                @include('partials.message_board')
                <!-- form start -->
                <form action="{{ route('students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="{{ $student->dob }}" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ $student->contact_number }}">
                    </div>
                    <div class="form-group">
                        <label for="contact_person">Contact Person Name</label>
                        <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ $student->contact_person }}">
                    </div>
                    <div class="form-group">
                        <label for="student_relation">Relation with Student</label>
                        <input type="text" class="form-control" id="student_relation" name="student_relation" value="{{ $student->student_relation }}">
                    </div>
                    <div class="form-group">
                        <label for="seat_type">Seat Type</label>
                        <input type="text" class="form-control" id="seat_type" name="seat_type" value="{{ $student->seat_type }}" required>
                    </div>
                    <div class="form-group">
                        <label for="donation">Donation</label>
                        <input type="number" class="form-control" id="donation" name="donation" value="{{ $student->donation }}">
                    </div>
                    <div class="form-group">
                        <label for="referred_by">Referred By</label>
                        <select class="form-control" id="referred_by" name="referred_by">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $student->referred_by == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="admission_no">Admission No</label>
                        <input type="text" class="form-control" id="admission_no" name="admission_no" value="{{ $student->admission_no }}" required>
                    </div>
                    <div class="form-group">
                        <label for="course_id">Course</label>
                        <select class="form-control" id="course_id" name="course_id" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="batch_id">Batch</label>
                        <select class="form-control" id="batch_id" name="batch_id" required>
                            <option value="">Select Batch</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ $student->batch_id == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department_id">Department</label>
                        <select class="form-control" id="department_id" name="department_id" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $student->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection










