

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<style>
    .modal-content {
    border-radius: 15px; /* Adjust the value as needed */
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
        <div class="container mt-2 pb-2">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Message Board -->
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                                <div id="student-list">
                            @include('partials.message_board')
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <!-- <a class="btn btn-lg btn-success mr-2" href="{{ route('students.create') }}">Add</a> -->
                    <a class="btn btn-lg btn-success mr-2" onclick="openModal(0)">Add</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-striped" id="student-table">
            <thead>
                <tr>
                    <th>ID</th>
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
                <!-- Content will be loaded here -->
            </tbody>
        </table>
        <div id="pagination-links">
            <!-- Pagination links will be loaded here -->
        </div>
    </div>
    <div class="modal fade" id="studentsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- Added modal-xl class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <h5 class="modal-title" id="msgAvailable" style="color:green;display:none;" ></h5>
                <h5 class="modal-title" id="msgUnAvailable" style="color:red;display:none;"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="card-body">
                    <!-- form start -->
                     
                    <input type="hidden" class="form-control" id="studentid" name="studentid" >
                    <form  id="students_store">
                  @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    @csrf
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
                                    <label for="referred_by">Referred By</label>
                                    <select class="form-control" id="referred_by" name="referred_by">
                                        <option value="">Select User</option>
                                        @foreach($managementUsers as $managementUser)
                                        <option value="{{ $managementUser->id }}">{{ $managementUser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div> <!-- /.row -->

                        <div class="row">

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
                                    <select class="form-control" id="batch_id" name="batch_id" onchange="seatFromBatchCheck(this.value);"required>
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
                            
                            <!-- <div class="col-md-12 text-right"> 
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> -->
                        </div> <!-- /.row -->
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveForm();" id="submit_student" style="display:none;">Save changes</button>
                <button type="button" class="btn btn-primary" onclick="updateForm();" id="update_student" style="display:none;">Update changes</button>
            </div>
        
        </div>
    </div>
</div>

    </div><!-- /.container-fluid -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function editModal(val) {
    // Retrieve the data-id attribute
    const id = val.getAttribute('data-id');
    const name = val.getAttribute('data-name');
    const dob = val.getAttribute('data-dob');
    const contact_number = val.getAttribute('data-contact_number');
    const contact_person = val.getAttribute('data-contact_person');
    const student_relation = val.getAttribute('data-student_relation');
    const seat_type = val.getAttribute('data-seat_type');
    const donation = val.getAttribute('data-donation');
    const referred_by = val.getAttribute('data-referred_by');
    const address = val.getAttribute('data-address');
    const gender = val.getAttribute('data-gender');
    const admission_no = val.getAttribute('data-admission_no');
    const course = val.getAttribute('data-course');
    const batch = val.getAttribute('data-batch');
    const department = val.getAttribute('data-department');
$('#studentid').val(id);
$('#name').val(name);
$('#admission_no').val(admission_no);
$('#contact_person').val(contact_person);
$('#contact_number').val(contact_number);
$('#student_relation').val(student_relation);
$('#dob').val(dob);
$('#referred_by').val(referred_by);
$('#seat_type').val(seat_type);
$('#donation').val(donation);
$('#course_id').val(course);
$('#batch_id').val(batch);
$('#department_id').val(department);
$('#address').val(address);
if(gender=='male')
{$('#gender_male').prop('checked', true);}
else if(gender=='female')
{// Set gender to female
$('#gender_female').prop('checked', true);}



    $('#studentsModal').modal('show');
    $('#submit_student').hide();   
    $('#update_student').show(); 
    $('#exampleModalLabel').html('Edit Students');
    }

function openModal(val)
{
  
    if(val==0)
    {
        $('#studentsModal').modal('show');
        $('#exampleModalLabel').html('Add Students');
        $('#submit_student').show();   
        $('#update_student').hide(); 
        $('#msgAvailable').hide();  
        $('#msgUnAvailable').hide();
        $('#studentid').val('');  
        $('#students_store')[0].reset();
        
    }

}
function saveForm() {
    var formData = $('#students_store').serialize();

    // Clear previous errors
    $('.error').remove();

    $.ajax({
        url: '{{ route("students.store") }}',
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 200) {
  
                $('#students_store')[0].reset(); // Reset form after successful submission
                loadTable();
                Swal.fire({
  title: response.msg,
  text: "",
  icon: "success"
});
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) { // Validation errors
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    var input = $('#' + key);
                    input.after('<div class="error" style="color:red;">' + value[0] + '</div>');
                });
            } else {
                alert('An error occurred. Please try again.'); // General error message
            }
        }
    });
}
function updateForm() {
    var formData = $('#students_store').serialize();
  var id =$('#studentid').val();

    // Clear previous errors
    $('.error').remove();

    $.ajax({
        url: '{{ route("students.update", "") }}/' + id,
        type: 'PUT',
        data: formData,
        success: function(response) {
            if (response.status === 200) {
  
                $('#students_store')[0].reset(); // Reset form after successful submission
                Swal.fire({
  title: response.msg,
  text: "",
  icon: "success"
});
                loadTable();

            }
        },
        error: function(xhr) {
            if (xhr.status === 422) { // Validation errors
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    var input = $('#' + key);
                    input.after('<div class="error" style="color:red;">' + value[0] + '</div>');
                });
            } else {
                alert('An error occurred. Please try again.'); // General error message
            }
        }
    });
}


function seatFromBatchCheck(batchId)
{
    var seatid=$('#seat_type').val();
    var course_id=$('course_id').val();
    var studentid=$('#studentid').val();
    $.ajax({
            url: '{{route('students.seats.check')}}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                seatid: seatid,
                batchId:batchId,
                course_id:course_id
          
            },
            success: function(response) {
            var status=response.status;
            var msg=response.msg;
           
            if(status=="Available")
            {
                if(studentid=='')
            {
                $('#submit_student').show();
                $('#update_student').hide(); 
            }
            else
            {
                $('#submit_student').hide();   
                $('#update_student').show(); 
            }
          
            
                  
                $('#msgAvailable').show(); 
                $('#msgUnAvailable').hide(); 
                 
                $('#msgAvailable').html(msg);  
            }
            else  if(status=="NotAvailable")
            {
                if(studentid=='')
            {
                $('#submit_student').show();
            }
            $('#submit_student').hide();   
            $('#update_student').hide(); 
                $('#msgUnAvailable').show(); 
                $('#msgAvailable').hide(); 
                 
                $('#msgUnAvailable').html(msg);   
            }
    
            },
            error: function(xhr, status, error) {
                // Handle error response
                $('#msgUnAvailable').hide(); 
                $('#msgAvailable').hide(); 
                // alert(status);
            }
        });
}

            loadTable();

            function loadTable(page = 1) {
                $.ajax({
                    url: '{{ route("students.loadTable") }}',
                    data: { page: page },
                    success: function(response) {
                        if (response.status === 200) {
                            $('#student-table tbody').html(response.data);
                            $('#pagination-links').html(response.links);
                        }
                    }
                });
            }

            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var page = url.split('page=')[1];
                loadTable(page);
            });
    
</script>
<!-- /.content -->
@endsection




