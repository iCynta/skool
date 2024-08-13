@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Payments</li>
                    <li class="breadcrumb-item active">{{ isset($payment) ? 'Edit' : 'New' }}</li>
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
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($payment) ? 'Edit Payment' : 'Add Payment' }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form
                        action="{{ isset($payment) ? route('payments.update', $payment->id) : route('payments.store') }}"
                        method="POST" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        @if(isset($payment))
                            @method('PUT')
                        @endif

                        <!-- <div class="form-group row">
                            <label for="paid_by" class="col-sm-2 col-form-label">Paid By:</label>
                            <div class="col-sm-10">
                                <input type="number" name="paid_by" class="form-control @error('paid_by') is-invalid @enderror" value="{{ old('paid_by', $payment->paid_by ?? '') }}" required>
                                @error('paid_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="payment_type" class="col-sm-2 col-form-label">Payment Type:</label>
                            <div class="col-sm-10">
                                <select name="payment_type" id="payment_type"
                                    class="form-control @error('payment_type') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('payment_type', $payment->payment_type ?? '') == '' ? 'selected' : '' }}>Select Payment Type</option>
                                    <option value="Bank" {{ old('payment_type', $payment->payment_type ?? '') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                    <option value="Management" {{ old('payment_type', $payment->payment_type ?? '') == 'Management' ? 'selected' : '' }}>Management</option>
                                </select>
                                @error('payment_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- User Field -->
                        <div class="form-group row">
                            <label for="paid_to" class="col-sm-2 col-form-label">Paid To (optional):</label>
                            <div class="col-sm-10">
                                <select name="paid_to" id="paid_to"
                                    class="form-control @error('paid_to') is-invalid @enderror">
                                    <option value="" disabled {{ old('paid_to', $payment->paid_to ?? '') == '' ? 'selected' : '' }}>Select User</option>
                                    <!-- User options will be dynamically loaded -->
                                </select>
                                @error('paid_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="paid_date" class="col-sm-2 col-form-label">Paid Date:</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="paid_date" class="form-control @error('paid_date') is-invalid @enderror" value="{{ old('paid_date', isset($payment->paid_date) ? $payment->paid_date->format('Y-m-d\TH:i') : '') }}" required>
                                @error('paid_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="detail" class="col-sm-2 col-form-label">Payment Detail (optional):</label>
                            <div class="col-sm-10">
                                <textarea name="detail"
                                    class="form-control @error('detail') is-invalid @enderror">{{ old('detail', $payment->detail ?? '') }}</textarea>
                                @error('detail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_slip" class="col-sm-2 col-form-label">Payment Slip (optional):</label>
                            <div class="col-sm-10">
                                <input type="file" name="payment_slip"
                                    class="form-control @error('payment_slip') is-invalid @enderror"
                                    accept=".pdf,.jpeg,.jpg,.png,.gif">
                                @error('payment_slip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if(isset($payment) && $payment->payment_slip)
                                    <p>Current File: {{ $payment->payment_slip }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-dark">{{ isset($payment) ? 'Update' : 'Create' }}
                                    Payment</button>
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


@push('scripts')
    <script>
        document.getElementById('payment_type').addEventListener('change', function () {
            const paymentType = this.value;
            const paidToSelect = document.getElementById('paid_to');

            if (paymentType === 'Management') {
                fetchUsersWithCourse(1).then(users => {
                    // Clear existing options
                    paidToSelect.innerHTML = '<option value="" disabled>Select User</option>';

                    // Populate new options
                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = user.name;
                        paidToSelect.appendChild(option);
                    });
                });
            } else {
                // Clear the select if not 'Management'
                paidToSelect.innerHTML = '<option value="" disabled>Select User</option>';
            }
        });

        async function fetchUsersWithCourse(courseId) {
            const response = await fetch(`/api/management/users?course_id=${courseId}`);
            const data = await response.json();
            return data.users;
        }
    </script>
@endpush