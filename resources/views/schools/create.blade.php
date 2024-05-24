

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
                    <li class="breadcrumb-item">Schools</li>
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
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New School</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('schools.add')}}" method="post">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">School Name</label>
                    <input type="text" name="name" class="form-control" id="name" required="true" placeholder="Name of the school">
                  </div>

                  <div class="form-group">
                    <label for="code">School Code</label>
                    <input type="text" name="code" class="form-control" id="code" required="true" placeholder="Code of School">
                  </div>

                  <div class="form-group">
                    <label for="affiliation_no">Affiliation Number</label>
                    <input type="text" name="affiliation_no" class="form-control" id="affiliation_no" placeholder="School Affiliation Number">
                  </div>

                  <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Contact Number">
                  </div>

                  <div class="form-group">
                    <label for="email">Contact Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Contact Email">
                  </div>

                  <div class="col-sm-12">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="School Address"></textarea>
                      </div>
                    </div>

                  <div class="form-group">
                    <label for="logo">Logo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="logo" class="custom-file-input" id="logo">
                        <label class="custom-file-label" for="logo">Choose</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
</div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection









