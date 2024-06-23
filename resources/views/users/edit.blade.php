
@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Employee Master</li>
                    <li class="breadcrumb-item">Employee</li>
                    <li class="breadcrumb-item active">update</li>
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
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Update Employee Details</h3>
            </div>
                <!-- /.card-header -->
            <div class="card-body">
            @include('partials.message_board')
                <!-- form start -->
                <form method="POST" action="{{ route('user.add') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}"/>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name ?? ''  }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? '' }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @php
                        $auth_user = Auth::user();      
                        @endphp
                        @if(Auth::user()->role->name === "Management")
                        <div class="row mb-3">
                            <label for="branch" class="col-md-4 col-form-label text-md-end">{{ __('Employee Under') }}</label>

                            <div class="col-md-6">
                                <select id="course_id" class="form-control @error('course_id') is-invalid @enderror" name="course_id" >
                                    <option value=""> -- Select Branch -- </option>
                                    @forelse($courses as $course)
                                    <option value="{{$course->id}}" {{ $user->course_id == $course->id ? "selected = true" : ''}}">{{$course->name }}</option>
                                    <!-- Add more options as needed -->
                                    @empty
                                    <option value="">No Branch to select</option>
                                    @endforelse
                                </select>

                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @else
                            <input type="hidden" name="course_id" value="{{Auth::user()->course_id }}"/>
                        
                        @endif

                        <div class="row mb-3">
                            <label for="designation" class="col-md-4 col-form-label text-md-end">{{ __('Designation') }}</label>

                            <div class="col-md-6">
                                <select id="designation" class="form-control @error('designation') is-invalid @enderror" name="designation" >
                                    <option value="">Select Designation</option>
                                    <option value="Manager" {{ $user->designation === 'Manager' ? "selected = true" : '' }}>Manager</option>
                                    <option value="Accountant" {{ $user->designation === 'Accountant' ? "selected = true" : '' }}>Accountant</option>
                                    <option value="Teacher" {{ $user->designation === 'Teacher' ? "selected = true" : '' }}>Teacher</option>
                                    <<option value="Staff" {{ $user->designation === 'Staff' ? "selected = true" : '' }}>Staff</option>
                                    <option value="Other" {{ $user->designation === 'Other' ? "selected = true" : '' }}>Other</option>
                                </select>

                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                <option value="">Select User Role</option>
                                    @foreach($roles as $role)                                        
                                        <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? "selected = true" : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" >{{ $user->address}}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" >

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dob" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                            <div class="col-md-6">
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{$user->dob}}" >

                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary float-right">
                                    {{ __('Update Details') }}
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection










