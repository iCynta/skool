@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Payment History</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Payments</li>
                    <li class="breadcrumb-item active"><a href="#">History</a></li>
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
                        @include('partials.message_board')
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-md btn-success m-2" href="{{ route('payments.cashInHand.settle') }}">Settle A Payment</a>
                    </div>
                </div>
                <div class="row justify-content-center">

                    <div class="col-md-4">
                        <!-- Display totals by payment type -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h4 class="card-title">Summary</h4>
                            </div>
                            <div class="card-body">
                                @if($totalsByType->isEmpty())
                                    <p class="text-muted">No payment data available.</p>
                                @else
                                    <table class="table table-sm table-condensed table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Payment Type</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($totalsByType as $type)
                                                <tr>
                                                    <td>{{ ucfirst($type->payment_type )}}</td>
                                                    <td>{{ number_format($type->total_amount, 2) }}</td>
                                                </tr>
                                                @if($type->payment_type === "management")
                                                    <tr>
                                                        <td colspan="2">
                                                           
                                                            
                                                                <ul class="list-group">
                                                                    @foreach ($totalsByUserForManagement as $userTotal)
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                            {{ $userTotal->paidTo->name ?? 'Unknown' }}
                                                                            <span class="badge bg-primary rounded-pill">{{ number_format($userTotal->total_amount, 2) }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="table-responsive">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h4 class="card-title">Payment History</h4>
                                </div>
                                <div calss="card-body">
                                    <div id="accordion">
                                        <table class="table table-sm table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Paid On</th>
                                                    <th>Type</th>
                                                    <th>Paid To</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($payments as $payment)
                                                    <tr class="bg-light">
                                                        <td>{{$loop->index + 1}}</td>
                                                        <td>{{$payment->paid_date}}</td>
                                                        <td>{{ucfirst($payment->payment_type)}}</td>
                                                        <td>{{ $payment->paidTo->name ?? "-" }}</td>
                                                        <td>{{$payment->amount}}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-info" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                                                Detail
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" style="padding: 0;">
                                                            <div id="collapse{{ $loop->index }}" class="collapse" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordion">
                                                                <div class="card-body">
                                                                    <div class="container-fluid">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-sm table-bordered table-condensed">
                                                                                <thead class="bg-dark text-white">
                                                                                    <tr>
                                                                                        <th>Receipt No:</th>
                                                                                        <th>Student</th>
                                                                                        <th>Payment Type</th>
                                                                                        <th>Amount</th>
                                                                                        <th>Received On</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @forelse ($payment->relatedExpenses as $relatedExpense)
                                                                                        <tr>
                                                                                            <td>{{$relatedExpense->reciept_no}}</td>
                                                                                            <td>{{$relatedExpense->student->name ?? '-'}}</td>
                                                                                            <td>{{$relatedExpense->expense->expense_name ?? '-'}}</td>
                                                                                            <td>{{$relatedExpense->amount}}</td>
                                                                                            <td>{{$relatedExpense->expense->created_at ?? '-'}}</td>
                                                                                        </tr>
                                                                                    @empty
                                                                                        <tr>
                                                                                            <td colspan="5"> No related details found.</td>
                                                                                        </tr>
                                                                                    @endforelse                         
                                                                                        
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6"><p>No payment history available.</p></td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
