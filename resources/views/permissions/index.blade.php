@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Role and Permissions</h1>
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
                        <a class="btn btn-lg btn-success mr-2" href="{{ route('schools.create') }}">Add</a>
                    </div>
                </div>            
            </div>
        </div>

        <div class="container">
            
            @foreach($roles as $role)
                <form action="{{ route('roles-permissions.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="role_id" value="{{ $role->id }}">

                    <div class="card card-dark mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title">{{ $role->name }}</h2>
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm select-all" data-role-id="{{ $role->id }}">Select All</button>
                                <button type="button" class="btn btn-secondary btn-sm deselect-all" data-role-id="{{ $role->id }}">Deselect All</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($permissions as $module => $modulePermissions)
                                <div class="card card-default mb-3">
                                    <div class="card-header bg-light">
                                        <h4 class="card-title">{{ ucfirst($module) }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        @foreach($modulePermissions as $permission)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input role-permission-{{ $role->id }}" id="{{ $permission->name }}_{{ $role->id }}" 
                                                        name="permissions[]" value="{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $permission->name }}_{{ $role->id }}">
                                                        {{ ucfirst(str_replace('_', ' ', preg_replace('/^(.+?)_(.+)$/', '$2 $1', $permission->name))) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.select-all').forEach(function (button) {
            button.addEventListener('click', function () {
                alert("Select All");
                var roleId = this.getAttribute('data-role-id');
                document.querySelectorAll('.role-permission-' + roleId).forEach(function (checkbox) {
                    checkbox.checked = true;
                });
            });
        });

        document.querySelectorAll('.deselect-all').forEach(function (button) {
            button.addEventListener('click', function () {
                var roleId = this.getAttribute('data-role-id');
                document.querySelectorAll('.role-permission-' + roleId).forEach(function (checkbox) {
                    checkbox.checked = false;
                });
            });
        });
    });
</script>
@endsection
