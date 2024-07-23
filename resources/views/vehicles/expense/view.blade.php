

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Vehicle Master</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Management Corner</li>
                    <li class="breadcrumb-item">Vehicle Master</li>
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
                    <a class="btn btn-md btn-success mr-2" href="{{ route('vehicle.expense.new') }}">New Expense</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="bg-dark">
                <tr>
                    <th colspan="2">Vehicle Expense Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-2"> Plate Number :</td> <td>{{$expense->vehicle->plate_number}}</td>
                </tr>
                <tr>
                    <td class="col-2"> Amount :</td> <td>{{$expense->amount}}/-</td>
                </tr>
                <tr>
                    <td> Expense Type :</td> <td>{{$expense->expenseType->name}}</td>
                </tr>
                <tr>
                    <td> Description :</td> <td>{{$expense->description}}</td>
                </tr>  
            </tbody>
            <tfoot class="">
                <tr >
                    <td  colspan="2" class="text-center"> 
                        <a href="{{route('vehicle.expense.voucher',['expense_id'=>$expense->id])}}" target="__blank" class="btn btn-sm btn-primary">Print Voucher</a>
                        <a href="{{route('vehicle.expense.index')}}" class="btn btn-sm btn-secondary">Back</a>
                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

<!-- @push('scripts')
    
@endpush -->


