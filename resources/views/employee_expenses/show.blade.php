@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Employee Expenses</li>
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
                    <h3 class="card-title">Expense Detail</h3>
                    <a href="{{ route('print.expense.voucher', ['voucher' => $expense->voucher_no]) }}"target="__blank" class="btn btn-sm btn-success float-right" id="printButton">Print</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive printable">
                        <table class="table table-t table-borderless">
                            <thead class="thead-light">
                                <tr>
                                    <th class="col-md-4 col-sm-5 col-xs-6">Voucher</th>
                                    <th>Date: {{ $expense->created_at}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Voucher Number</td> <td>{{ $expense->voucher_no}}</td>
                                </tr>
                                <tr>
                                    <td>Employee Name</td> <td>{{ $expense->employee->name}}</td>
                                </tr>
                                <tr>
                                    <td>Designation</td> <td>{{ $expense->employee->designation}}</td>
                                </tr>
                                <tr>
                                    <td>Expense Type</td> <td>{{ $expense->expenseMaster->name}}</td>
                                </tr>
                                <tr>
                                    <td>Amount</td> <td>{{ $expense->amount}}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2"><p class="text-right text-sm text-muted">Created By: {{$expense->createdBy->name}}</p></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                 @php
                     //dd($expense);
                 @endphp   
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
