@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header card">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item">Profile</li>
                        <li class="breadcrumb-item active">View</li>
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
                <div class="card card-info">
                    <div class="card-header">
                        <h2 class="card-title">Employee Details</h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('partials.message_board')
                        <div class="table-responsive">
                            <table class= "table table-sm table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <td>Name</td><td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td><td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td><td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Designation</td><td>{{$user->designation ?? 'Not Available'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Course</td><td>{{$user->course->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Role</td><td>{{$user->role->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td><td>{{$user->address ?? 'Not Available'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Of Birth</td><td>{{$user->dob?? 'Not Available'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Created On</td><td>{{$user->created_at}}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan=2 class="text-right">
                                            <a href="{{route('user.index')}}" class="btn btn-sm btn-secondary mr-1">Back </a>
                                            @if($user->is(Auth::user()) || Auth::user()->role->name === "Management")
                                                <a href="{{route('user.edit',['id'=>$user->id])}}" class="btn btn-sm btn-warning mr-1">Edit Profile</a>
                                            @endif
                                            @if($user->is(Auth::user()) || Auth::user()->role->name === "Management")
                                                    <button type="button" class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#changePasswordModal">
                                                    Change Password
                                                </button>
                                            @endif
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection



<!-- Modal Structure -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="changePasswordForm" action="{{ route('user.updatePassword') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')

    <script>
        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;
            var errorDiv = document.getElementById('passwordMatchError');
        });

    </script>

@endpush
