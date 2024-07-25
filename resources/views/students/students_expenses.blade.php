@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')


<style>
    .modal-content {
        border-radius: 15px;
        /* Adjust the value as needed */
    }

    .info-box {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .info-box p {
        margin: 0;
        /* Remove default margin */
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Students</h1>
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
            <div class="col-md-6 float-left">
                <div class="card">
                    <div class="card-header bg-light"> Search Admission No</div>
                    <div class="card-body">
                        <div class="form-group d-flex">
                            <select id="admissionSearch" class="form-control">
                                <option>-- Search with Admission --</option>
                            </select>
                            <button class="btn btn-primary ml-2" id="searchButton">Search</button>
                            <button class="btn btn-secondary ml-2" id="resetButton"
                                onclick="location.reload();">Reset</button>
                        </div>
                    </div>
                    <div class="card-footer bg-light"></div>
                </div>
            </div>
            <div class="col-md-6 float-left" id="infoBox" style="display: none;">
                <div class="card">
                    <div class="card-header bg-light">Student Detail</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <!-- <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                        </tr>
                                    </thead> -->
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td id="name"></td>
                                    </tr>
                                    <tr>
                                        <td>Date Of Birth</td>
                                        <td id="dob"></td>
                                    </tr>
                                    <tr>
                                        <td>Batch</td>
                                        <td id="batchInfo"></td>
                                    </tr>
                                    <tr>
                                        <td>Course</td>
                                        <td id="course"></td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td id="department"></td>
                                    </tr>
                                    <tr>
                                        <td>Course Fee</td>
                                        <td id="coursefee"></td>
                                    </tr>
                                    <tr>
                                        <td>Course Tenure</td>
                                        <td id="tenuture"></td>
                                    </tr>
                                    <tr>
                                        <td>Donation</td>
                                        <td id="donation"></td>
                                    </tr>
                                    <tr>
                                        <td>Paid</td>
                                        <td id="paidinst"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Paid </td>
                                        <td id="TotalamtPaid"></td>
                                    </tr>
                                    <tr>
                                        <td>Balance Fee</td>
                                        <td id="balancefee"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- <div class="card-footer">
                            Footer
                        </div> -->
                </div>
            </div>
            <div class="col-md-6 float-left" id="expenseDropdown" style="display: none;">
                <div class="card">
                    <div class="card-header bg-light">Make Payment</div>
                    <div class="card-body">
                        <div class="form-group mt-3">

                            <label for="expenseSelect">Select Expense:</label>

                            <select class="form-control" id="expenseSelect">
                                <option value="">Select an expense</option>

                                @foreach ($expenses as $exprow)
                                    <option value="{{$exprow['id']}}">{{$exprow['expense_name']}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group mt-3">
                            <label for="feeAmount">Amount:</label>
                            <input type="number" class="form-control" id="feeAmount" placeholder="Enter Fee Amount"
                                style="display: none;">
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button class="btn btn-success" id="submitFeeButton" style="display: none;">Make
                                Payment</button>
                            <button class="btn btn-success" id="updateFeeButton" style="display:none;">Edit
                                Payment</button>
                            <button class="btn btn-warning" id="resetFeeButton" style="display:none;"
                                onclick="ResetExpense();">Reset</button>
                            <input type="text" id="expenseid" style="display:none;" />
                        </div>
                        <div class="suggestions" id="suggestions" style="display: none;"></div>
                    </div>
                    <div class="card-footer">Footer</div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-head">Payments</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="student-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Expense Name</th>
                                    <th>ReceiptNo</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Content will be loaded here -->
                            </tbody>
                        </table>
                        <div id="pagination-links">
                            <!-- Pagination links will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->


<!-- Load jQuery first -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Then load Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Initialize Select2
        $('#admissionSearch').select2({
            placeholder: 'Search Admission No',
            ajax: {
                url: '{{ route("students.admission.check") }}', // Update to your route
                type: 'POST',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        query: params.term, // search term
                        _token: '{{ csrf_token() }}' // Add CSRF token here
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            allowClear: true
        });

        $('#searchButton').click(function () {
            var admissionNo = $('#admissionSearch').val();

            // Perform your AJAX search here
            $.ajax({
                url: '{{ route("student.expenses.details")}}', // Update this URL to your search route
                method: 'POST',
                data: { admission_no: admissionNo, _token: '{{ csrf_token() }}' },
                success: function (response) {
                    console.log(response);
                    loadExpenses();
                    $('#batchInfo').text(response.batch);
                    $('#name').text(response.name);
                    $('#course').text(response.course);
                    $('#department').text(response.department);
                    $('#coursefee').text(response.coursefee);
                    $('#dob').text(response.dob);
                    $('#tenuture').text(response.tenuture);
                    $('#paidinst').text(response.paidinst);
                    $('#TotalamtPaid').text(response.TotalamtPaid);
                    $('#balancefee').text(response.balancefee);
                    $('#donation').text(response.donation);
                    $('#infoBox').show();
                    $('#feeAmount').show(); // Show fee amount input
                    $('#expenseDropdown').show(); // Show dropdown
                    $('#submitFeeButton').show(); // Show submit button
                }
            });
        });

        $('#resetButton').click(function () {
            $('#admissionSearch').val(null).trigger('change'); // Clear the select box
            $('#infoBox').hide(); // Hide the info box
            $('#suggestions').hide(); // Hide the suggestions
            $('#feeAmount').val(''); // Clear fee amount
            $('#feeAmount').hide(); // Hide fee amount input
            $('#expenseDropdown').hide(); // Hide dropdown
            $('#submitFeeButton').hide(); // Hide submit button
        });

        $('#submitFeeButton').click(function () {
            var feeAmount = $('#feeAmount').val();
            var expenseId = $('#expenseSelect').val();
            // Perform your AJAX submit here
            $.ajax({
                url: '{{ route("student.expenses.reciepts.save")}}', // Update this URL to your submit fee route
                method: 'POST',
                data: {
                    admission_no: $('#admissionSearch').val(),
                    amount: feeAmount,
                    expense_id: expenseId,
                    _token: '{{ csrf_token() }}' // Add CSRF token for security
                },
                success: function (response) {
                    loadExpenses();
                    $('#searchButton').click();
                    Swal.fire({
                        title: response.msg,
                        icon: "success"
                    });
                    // Reset fields or perform other actions
                },
                error: function (xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });
        $('#updateFeeButton').click(function () {
            // Get values from the modal inputs
            var feeAmount = $('#feeAmount').val();
            var expenseId = $('#expenseSelect').val();
            var id = $('#expenseid').val();
            const url = '{{ route('student.expenses.reciepts.update', '') }}' + '/' + id;


            // Send the AJAX request
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: feeAmount,
                    expense_id: expenseId,

                },
                success: function (response) {
                    // Handle success response
                    Swal.fire({
                        title: response.msg,
                        icon: "success"
                    });
                    loadExpenses();
                    ResetExpense();
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error('Error saving data', error);
                }
            });

        });
    });
    function editExpense(val) {
        const id = val.getAttribute('data-id');
        const expense_name = val.getAttribute('data-expense_name');
        const amount = val.getAttribute('data-amount');
        $('#expenseSelect').val(expense_name);
        $('#feeAmount').val(amount);
        $('#expenseid').val(id);
        $('#submitFeeButton').hide();
        $('#updateFeeButton').show();
        $('#resetFeeButton').show();

    }
    function ResetExpense() {

        $('#expenseSelect').val('');
        $('#feeAmount').val('');
        $('#expenseid').val('');
        $('#submitFeeButton').show();
        $('#updateFeeButton').hide();
        $('#resetFeeButton').hide();

    }
    function loadExpenses() {
        $.ajax({
            url: '{{ route("student.expenses.reciepts")}}', // Update this URL to your search route
            method: 'POST',
            data: { admission_no: $('#admissionSearch').val(), _token: '{{ csrf_token() }}' },
            success: function (response) {
                $('#student-table tbody').html(response.data);
                // $('#pagination-links').html(response.links);
            }
        });

    }
</script>

<!-- /.content -->
@endsection