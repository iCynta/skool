

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Management Corner</li>
                    <li class="breadcrumb-item">School</li>
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
        <div class="col-md-6">
        <h1>Schools</h1>
        </div>
        <div class="col-md-6  text-right">
        <a class="btn btn-lg btn-success mr-2" href="{{route('schools.create')}}">Add</a>
        </div>
    </div>
    <div class="table-responsive">
        <table id="schoolsTable" class="table table-sm table-striped table-bordered">
            <thead class="bg-dark">
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Affiliation No</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('scripts')
    
    $(document).ready(function() {
        alert("Data table is loading");
        $('#schoolsTable').DataTables({
            processing: true,
            serverSide: true,
            ajax: '{{ route('schools.getSchools') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'code', name: 'code' },
                { data: 'affiliation_no', name: 'affiliation_no' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'address', name: 'address' },
                { data: 'action', name: 'action', orderable: true, searchable: true },
            ]
        });
    });
   
@endsection
