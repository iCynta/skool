

@extends('layouts.dashboard')

@section('title', 'Dashboard:Batch')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Management Corner</li>
                    <li class="breadcrumb-item">Batch</li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content card">
    <div class="container-fluid">
        <div class="container">
        <div class="card">
              <div class="card-header bg-dark">
                <h3 class="card-title">New Batch</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('batch.add')}}" method="post">
              @csrf
                <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Batch Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" required="true" placeholder="Batch name Eg: B.Ed 2024-2026">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Select Course <span class="text-danger">*</span></label>
                            <select name="course_id" class="form-control select2" style="width: 100%;">                        
                                <option value="">Select a Course</option>
                                @forelse ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @empty
                                    <option disabled>No courses available</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>                

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                        <label for="merit_seat">Number of Merit Seats <span class="text-danger">*</span></label>
                        <input type="number" name="merit_seat" class="form-control" id="merit_seat" required="true" placeholder="Number of seats available in merit quota">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                        <label for="payment_seat">Number of Payment Seat <span class="text-danger">*</span></label>
                        <input type="number" name="payment_seat" class="form-control" id="payment_seat" required="true" placeholder="Number of seats in Managemenet Quota">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                        <label for="start_date">Batch Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" id="start_date"  placeholder="Batch will start on">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                        <label for="course_tenure">Course Tenure in Months <span class="text-danger">*</span></label>
                        <input type="number" name="course_tenure" class="form-control" id="course_tenure"  placeholder="How many months?">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                        <label for="tution_fee">Tution Fee for the batch <span class="text-danger">*</span></label>
                        <input type="number" name="tution_fee" class="form-control" id="tution_fee"  placeholder="Tution Fee for the batch">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label> <small class="form-text text-danger">Fields with '*' are mandatory.</small> </label> <br />
                            <button type="submit" class="btn btn-primary float-right mr-2">Create</button>
                        </div>
                        
                    </div>
                </div>

                <!-- /.card-body -->

                <div class="card-footer">
                  
                </div>
              </form>
</div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection









