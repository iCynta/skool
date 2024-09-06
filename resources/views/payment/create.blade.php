@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Payments</li>
                    <li class="breadcrumb-item active">settle</li>
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Payments to Settle</h3>
                    <a href="{{route('payments.history')}}" class="btn btn-sm btn-info float-right">View History</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Receipt No</th>
                                    <th>Received For</th>
                                    <th>Received From</th>
                                    <th>Received On</th>
                                    <th>Amount</th>
                                    <th>Settle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments_to_settle as $payment_to_settle)
                                <tr>
                                    <td>{{ $payment_to_settle->reciept_no }}</td>
                                    <td>{{ $payment_to_settle->expense->expense_name }}</td>
                                    <td>{{ $payment_to_settle->student->name }}</td>
                                    <td>{{ $payment_to_settle->created_at->timezone('Asia/Kolkata')->format('Y-m-d H:i:s') }}                                    </td>
                                    <td class="amount">{{ $payment_to_settle->amount }}</td>
                                    <td>
                                        <input type="checkbox" value="{{ $payment_to_settle->id }}" name="payments[]"
                                            class="payment-checkbox">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">No payments to settle.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">{{ $payments_to_settle->links('vendor.pagination.bootstrap-4') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Inline Form -->
                        <form action="{{ route('payments.cashInHand.settle') }}" method="POST" class="form-horizontal">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="totalAmount">Total Amount:</label>
                                    <input type="text" class="form-control" id="totalAmount" name="amount" readonly>
                                </div>

                                <input type="hidden" id="selectedPayments" name="selected_payments">

                                <div class="form-group col-md-2">
                                    <label for="paymentType">Settle As:</label>
                                    <select class="form-control" id="paymentType" name="payment_type">
                                        <option value="management">Management</option>
                                        <option value="bank">Bank</option>
                                        <option value="treasury">Treasury</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="paid_to">Paid to:</label>
                                    <select class="form-control" id="paid_to" name="paid_to">
                                        <option value="">--Select--</option>
                                        @forelse($recipients as $recipient)
                                            <option value="{{ $recipient->id }}">{{ $recipient->name }}</option>
                                        @empty
                                        <option value="">--No Receipts--</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="detail">Description:</label>
                                    <textarea class="form-control" id="detail" name="detail" rows="1" placeholder="Enter description here"></textarea>
                                </div>

                                <div class="form-group col-md-2 align-self-end">
                                    <button type="submit" class="btn btn-primary">Settle Payments</button>
                                </div>
                            </div>
                        </form>




                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection


@push('scripts')
<!-- JavaScript to calculate total amount and manage selected IDs -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.payment-checkbox');
        const totalAmountField = document.getElementById('totalAmount');
        const selectedPaymentsField = document.getElementById('selectedPayments');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateForm);
        });

        function updateForm() {
            let totalAmount = 0;
            let selectedIds = [];

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const amount = parseFloat(checkbox.closest('tr').querySelector('.amount').innerText);
                    totalAmount += amount;
                    selectedIds.push(checkbox.value);
                }
            });

            totalAmountField.value = totalAmount.toFixed(2);
            selectedPaymentsField.value = selectedIds.join(',');
        }
    });
</script>
@endpush
