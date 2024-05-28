

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Management Corner</li>
                    <li class="breadcrumb-item">Course</li>
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
                <h3 class="card-title">New Course</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('course.add')}}" method="post">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Course Name</label>
                    <input type="text" name="name" class="form-control" id="name" required="true" placeholder="Name of the course">
                  </div>

                  <div class="form-group">
                    <label for="code">Course Code</label>
                    <input type="text" name="code" class="form-control" id="code" required="true" placeholder="Code of course">
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









