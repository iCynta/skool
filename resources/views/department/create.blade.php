

@extends('layouts.dashboard')

@section('title', 'Dashboard:Department')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Management Corner</li>
                    <li class="breadcrumb-item">Department</li>
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
        <div class="card">
              <div class="card-header bg-dark">
                <h3 class="card-title">New Department</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('department.add')}}" method="post">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Department Name</label>
                    <input type="text" name="name" class="form-control" id="name" required="true" placeholder="Name of the course">
                </div>

                <div class="form-group">
                    <label>Select Course</label>
                    <select name="course_id" class="form-control select2" style="width: 100%;">                        
                        <option value="">Select a Course</option>
                        @forelse ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @empty
                            <option disabled>No courses available</option>
                        @endforelse
                    </select>
                </div>

                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
</div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection









