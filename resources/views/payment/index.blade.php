
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
                    <!-- Message Board -->
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @include('partials.message_board')
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-md btn-success mr-2" href="{{ route('payments.cashInHand.settle') }}">Settle A Payment</a>
                </div>
            </div>            
        </div>
    </div>
    <div class=" table-responsive">
    <div id="accordion">
    <table class="table table-sm table-condensed ">
        <thead>
            <tr>
                <th>#</th>
                <th>Paid On</th>
                <th>Type</th>
                <th>Paid To</th>
                <th>Amount</th>
                <th>Detail</th>
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
                                        <thead class="bg-light">
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
                                                    <td colspan="2"> No related details found.</td>
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
    
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection







  