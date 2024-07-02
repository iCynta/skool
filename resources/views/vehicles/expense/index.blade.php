

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Vehicle Master</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Vehicle Master</li>
                    <li class="breadcrumb-item active"><a href="#">Expenses</a></li>
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
                    <a class="btn btn-md btn-success mr-2" href="{{ route('vehicle.expense.new') }}">Add Expense</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead class="bg-dark">
                <tr>
                    <th> Si:No</th>
                    <th> Vehicle Number</th>
                    <th> Expense </th>
                    <th> Date</th>
                    <th> Actions</th>
                </tr>
                <tr class="bg-light">
                    <form id="expense_filter_form">
                        <td><label class="form-label">Filter</label></td>
                        <td>
                            <select name="plate_number" id="plate_number" class="form-control form-control-sm">
                            <option value=""> Plate Number</option>
                                @forelse ($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}"> {{$vehicle->plate_number}}</option>
                                @empty
                                <option value=""> {--No Data Found--}</option>
                                @endforelse
                            </select>
                        </td>
                        <td>
                            <select name="expense_type" id="expense_type" class="form-control form-control-sm">
                                <option value=""> Expense Type</option>
                                @forelse ($expenseTypes as $expenseType)
                                <option value="{{$expenseType->id}}"> {{$expenseType->name}}</option>
                                @empty
                                <option value=""> {--No Data Found--}</option>
                                @endforelse
                            </select>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"/>
                                </div>
                                <div class="col-6">
                                    <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"/>
                                </div>
                            </div>
                            
                            
                        </td>
                        <td><button id="expense_filter_form_submit" class="btn btn-sm btn-info"> Filter</button></td>
                    </form>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                <tr>
                    <td> {{ $loop->index + 1 }} </td>
                    <td> {{ $expense->vehicle->plate_number }} </td>
                    <td> {{ $expense->expenseType->name }} </td>
                    <td> {{ $expense->created_at }} </td>
                    <td> 
                        <a href="{{route('vehicles.show',['vehicle'=>$expense->vehicle_id])}}" class="btn btn-sm btn-primary">VIEW</a>
                        <a href="#" class="btn btn-sm btn-danger">DELETE</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center"><p class="text-center text-warning"> No Vehicle found </p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

<!-- @push('scripts')
    
@endpush -->


