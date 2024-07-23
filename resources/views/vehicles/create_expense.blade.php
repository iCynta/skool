@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Vehicle Master</li>
                    <li class="breadcrumb-item">Vehicles</li>
                    <li class="breadcrumb-item">Expense</li>
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
    <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Message Board -->
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @include('partials.message_board')
                        </div>
                    </div>
                </div>
            </div>
        <div class="container">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Add Expense</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('vehicle.expense.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Vehicle</label>
                                    <select class="form-control" name="vehicle_id" id="vehicle_id">
                                        <option value=""> Select Vehicle</option>
                                        @forelse($vehicles as $vehicle)
                                        <option value="{{$vehicle->id}}">{{$vehicle->plate_number}}</option>
                                        @empty
                                        @endforelse

                                    </select>
                                        @error('vehicle_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expense_type">Expense Type</label>
                                    <select class="form-control" name="expense_id" id="expense_id">
                                        <option value=""> Select Expense Type</option>
                                        @forelse($vehicleExpenseMasters as $expense)
                                        <option value="{{$expense->id}}">{{$expense->name}}</option>
                                        @empty
                                        <option value=""> No Vehicle Found</option>
                                        @endforelse

                                    </select>
                                        @error('expense_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" name="amount" id="amount" class="form-control" min="0"/>
                                        @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror 
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control"
                                        rows="3"></textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror 
                                    
                                </div>
                            </div>
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