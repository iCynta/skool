@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Students</li>
                    <li class="breadcrumb-item active">New</li>
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
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Add Student</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="admission_no">Admission No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="admission_no" name="admission_no"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="contact_person">Contact Person</label>
                                    <input type="text" class="form-control" id="contact_person" name="contact_person">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="student_relation"> Relation with Student</label>
                                    <input type="text" class="form-control" id="student_relation"
                                        name="student_relation">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="seat_type">Seat Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="seat_type" id="seat_type" required="true">
                                        @forelse($seatTypes as $seatType)
                                        <option value="{{ $seatType->id }}"> {{ $seatType->name }} </option>
                                        @empty
                                        <option value=""> Select Seat Type </option>
                                        @endforelse
                                    </select>

                                </div>
                            </div>

                        </div> <!-- /.row -->

                        <div class="row">

                        <div class="col-md-3">
                                <div class="form-group">
                                    <label for="referred_by">Referred By</label>
                                    <select class="form-control" id="referred_by" name="referred_by">
                                        <option value="">Select User</option>
                                        @foreach($managementUsers as $managementUser)
                                        <option value="{{ $managementUser->id }}">{{ $managementUser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="donation">Donation</label>
                                    <input type="number" class="form-control" id="donation" name="donation">
                                </div>
                            </div>




                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="course_id">Course <span class="text-danger">*</span></label>
                                    <select class="form-control" id="course_id" name="course_id">
                                        @if(Auth()->user()->role->name !== "Management") readonly @endif required>
                                        @if(Auth()->user()->role->name !== "Management")
                                        <option value="{{ Auth::user()->course_id }}" selected>{{
                                            Auth::user()->course->name }}</option>
                                        @else
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="batch_id">Batch <span class="text-danger">*</span></label>
                                    <select class="form-control" id="batch_id" name="batch_id" required>
                                        <option value="">Select Batch</option>
                                        @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> <!-- /.row -->

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="department_id">Department <span class="text-danger">*</span></label>
                                    <select class="form-control" id="department_id" name="department_id" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" id="address" name="address" rows="1" maxlength="100" aria-label="Address"></textarea>
                                        <span class="input-group-text" id="charCount">100 / 100</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gender">Gender <span class="text-danger">*</span></label><br>
                                    <input type="radio" id="gender_male" name="gender" value="male">
                                    <label for="gender_male">Male</label>
                                    <input type="radio" id="gender_female" name="gender" value="female">
                                    <label for="gender_female">Female</label>
                                </div>
                            </div>
                            
                            <div class="col-md-12 text-right"> <!-- Move the submit button to the right -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div> <!-- /.row -->
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#address').on('input', function() {
            const maxLength = parseInt($(this).attr('maxlength'));
            const currentLength = $(this).val().length;
            const remaining = maxLength - currentLength;
            
            $('#charCount').text(`${remaining} / ${maxLength}`);
        });
    });
</script>
@endpush