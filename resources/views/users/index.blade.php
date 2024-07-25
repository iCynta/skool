

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Employees</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Management Corner</li>
                    <li class="breadcrumb-item">Department</li>
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
                    <a class="btn btn-lg btn-success mr-2" href="{{ route('register') }}">Add</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-light">
            <thead class="bg-dark">
                <tr>
                <th>Si No:</th> <th>Name</th> <th>Designation</th><th>Role</th><th>Course</th><th> Action</th>
                </tr>                
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->designation ?? 'No Designation'}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>{{$user->course->name}}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">View</a>
                            <a href="{{route('user.edit',['id'=>$user->id])}}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr class="" colspan="6">
                        <td>
                            <p class="text-info">No user found at this moment.</p>
                        </td>
                    </tr>
                @endforelse                
                
            </tbody>
            <tfooter></tfooter>
        </table>
    </div>
    
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection




