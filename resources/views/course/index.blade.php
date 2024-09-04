

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registered Courses</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Course</li>
                    <li class="breadcrumb-item active"><a href="#">New</a></li>
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
                    <a class="btn btn-lg btn-success mr-2" href="{{ route('course.create') }}">Add</a>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        {!! $dataTable->table(['id' => 'courses-table','class' => 'table table-condensed table-hover table-bordered']) !!}
    </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCourseForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Course Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="code">Course Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <input type="hidden" id="course_id" name="course_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>

        function editCourse(id) {
            var url = "{{ route('courses.edit', ':id') }}";
            url = url.replace(':id', id);

            $.get(url, function (data) {
                $('#name').val(data.name);
                $('#code').val(data.code);
                $('#course_id').val(data.id);
                $('#editCourseModal').modal('show');
            });
        }

        $('#editCourseForm').submit(function (e) {
            e.preventDefault();

            var id = $('#course_id').val();
            var url = "{{ route('courses.update', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    $('#editCourseModal').modal('hide');
                    toastr.success(response.success);
                    $('#courses-table').DataTable().ajax.reload(); // Reload DataTable
                },
                error: function (xhr) {
                    toastr.error('An error occurred while updating the course.');
                }
            });
        });

    //Course delete

    function confirmDelete(courseId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('courses.softDelete', ':id') }}'.replace(':id', courseId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.success,
                            'success'
                        );
                        $('#courses-table').DataTable().ajax.reload(); // Reload DataTable
                    },
                    error: function(xhr) {
                        console.log(url);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the course.',
                            'error'
                        );
                    }
                });
            }
        });
    }




</script>

@endpush


