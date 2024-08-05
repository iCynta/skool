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
                    <li class="breadcrumb-item active">Student Payment Report</li>
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
                    <tr><td colspan="11">Payment History</td></tr>
                    <tr class="bg-info">
                        <td colspan="11">
                            <form action="{{ route('reports.students.index') }}" method="GET">
                                <div class="row">
                                    @csrf
                                    <div class="col-md-2">
                                        <select name="course_id" id="course_id"
                                            class="form-control form-control-sm">
                                            <option value="">Select Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="batch_id" id="batch_id"
                                            class="form-control form-control-sm">
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                                    {{ $batch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="department_id" id="department_id"
                                            class="form-control form-control-sm">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="seat_type_id" id="seat_type_id"
                                            class="form-control form-control-sm">
                                            <option value="">Select Seat Type</option>
                                            @foreach($seatTypes as $seatType)
                                                <option value="{{ $seatType->id }}" {{ request('seat_type_id') == $seatType->id ? 'selected' : '' }}>
                                                    {{ $seatType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="date" name="from_date" id="from_date"
                                                    class="form-control form-control-sm"
                                                    value="{{ request('from_date') }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="date" name="to_date" id="to_date"
                                                    class="form-control form-control-sm"
                                                    value="{{ request('to_date') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-dark btn-sm">
                                            <i class="fa fa-search"></i> Filter
                                        </button>                                                
                                        <a href="{{ route('export.students', request()->query()) }}"
                                            class="btn btn-dark btn-sm">
                                            <i class="fa fa-file-export"></i> Export
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
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
                            <td>{{ $studentDetails[$student->id]['donation'] }}</td>
                            <td>{{ $studentDetails[$student->id]['TotalamtPaid'] }}</td>
                            <td>{{ $studentDetails[$student->id]['balancefee'] }}</td>
                            <td>{{ $student->created_at->format('d-m-Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#studentModal" data-name="{{ $student->name }}"
                                    data-course="{{ $student->batch->course->name ?? '-' }}"
                                    data-batch="{{ $student->batch->name ?? '-' }}"
                                    data-department="{{ $student->department->name ?? '-' }}"
                                    data-seat="{{ $seatTypesforTable[$student->seat_type] }}"
                                    data-donation="{{ $studentDetails[$student->id]['donation'] }}"
                                    data-fees-paid="{{ $studentDetails[$student->id]['TotalamtPaid'] }}"
                                    data-balance="{{ $studentDetails[$student->id]['balancefee'] }}"
                                    data-paidinst="{{ $studentDetails[$student->id]['paidinst'] }}"
                                    data-tenure="{{ $studentDetails[$student->id]['tenure'] }}"
                                    data-coursefee="{{ $studentDetails[$student->id]['coursefee'] }}">
                                    View
                                </button>
                            </td>
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

<!-- Student Detail Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Student Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td id="student-name"></td>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <td id="student-course"></td>
                        </tr>
                        <tr>
                            <th>Batch</th>
                            <td id="student-batch"></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td id="student-department"></td>
                        </tr>
                        <tr>
                            <th>Seat Type</th>
                            <td id="student-seat"></td>
                        </tr>
                        <tr>
                            <th>Tenure</th>
                            <td id="student-tenure"></td>
                        </tr>
                        <tr>
                            <th>Course Fee</th>
                            <td id="student-coursefee"></td>
                        </tr>
                        <tr>
                            <th>Donation Paid</th>
                            <td id="student-donation"></td>
                        </tr>
                        <tr>
                            <th>Fees Paid</th>
                            <td id="student-fees-paid"></td>
                        </tr>
                        <tr>
                            <th>Paid Installment</th>
                            <td id="student-paidinst"></td>
                        </tr>
                        <tr>
                            <th>Balance Fees</th>
                            <td id="student-balance"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#studentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name');
            var course = button.data('course');
            var batch = button.data('batch');
            var department = button.data('department');
            var seat = button.data('seat');
            var donation = button.data('donation');
            var feesPaid = button.data('fees-paid');
            var balance = button.data('balance');
            var paidinst = button.data('paidinst');
            var tenure = button.data('tenure');
            var coursefee = button.data('coursefee');

            // Update the modal's content
            var modal = $(this);
            modal.find('#student-name').text(name);
            modal.find('#student-course').text(course);
            modal.find('#student-batch').text(batch);
            modal.find('#student-department').text(department);
            modal.find('#student-seat').text(seat);
            modal.find('#student-donation').text(donation);
            modal.find('#student-fees-paid').text(feesPaid);
            modal.find('#student-balance').text(balance);
            modal.find('#student-paidinst').text(paidinst);
            modal.find('#student-tenure').text(tenure);
            modal.find('#student-coursefee').text(coursefee);
        });
    });

</script>
@endsection

@section('scripts')

@endsection