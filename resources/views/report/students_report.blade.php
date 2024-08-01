@extends('layouts.dashboard')

@section('title', 'Student Report')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Student Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item active">Student Report</li>
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
                        <!-- Optionally, you could add a button to add new student reports if needed -->
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-sm table-striped">
                <thead class="bg-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Department</th>
                        <th>Seat Type</th>
                        <th>Donation Paid</th>
                        <th>Fees Paid</th>
                        <th>Balance Fees</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    <tr class="bg-info">
                        <form action="{{ route('reports.students.index') }}" method="GET">
                            @csrf
                            <td></td>
                          
                            <td>
                                <select name="course_id" id="course_id" class="form-control form-control-sm">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="batch_id" id="batch_id" class="form-control form-control-sm">
                                    <option value="">Select Batch</option>
                                    @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                            {{ $batch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="department_id" id="department_id" class="form-control form-control-sm">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="seat_type_id" id="seat_type_id" class="form-control form-control-sm">
                                    <option value="">Select Seat Type</option>
                                    @foreach($seatTypes as $seatType)
                                        <option value="{{ $seatType->id }}" {{ request('seat_type_id') == $seatType->id ? 'selected' : '' }}>
                                            {{ $seatType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="date" name="from_date" id="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="date" name="to_date" id="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                            </td>
                            <td>
                            <button type="submit" class="btn btn-dark btn-sm">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                               
                                <button type="button" class="btn btn-dark btn-sm">
                                    <i class="fa fa-file-export"></i> Export
                                </button>
                            </td>
                            </form>
                        <td>
                            <td></td>
                            <td></td>
                            <td></td>
                             
                            </td>
                    </tr>
                </thead>
                <tbody>
                @php
                        $index = ($students->currentPage() - 1) * $students->perPage() + 1;
                    @endphp
                    @foreach($students as $student)
                        <tr>
                        <td>{{ $index++ }}</td> <!-- Index Column -->

                            <td>{{ $student->name }}</td>
                            <td>{{ $student->batch->course->name ?? '-' }}</td>
                            <td>{{ $student->batch->name ?? '-' }}</td>
                            <td>{{ $student->department->name ?? '-' }}</td>
                            <td>{{ $seatTypesforTable[$student->seat_type] }}</td>
                            <td>{{ $studentDetails[$student->id]['donation']}}</td>
                            <td>{{ $studentDetails[$student->id]['TotalamtPaid']}}</td>
                            <td>{{ $studentDetails[$student->id]['balancefee']}}</td>
                            <td>{{ $student->created_at->format('d-m-Y') }}</td>
                            <td>View</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="7">
                            <div class="pagination justify-content-center">
                                {{ $students->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
