

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
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
            {{-- <div class="col-md-4">
                <div class="card card-success">
                    <div class="card-header">
                        <div class="card-title text-center">Total Students</div>
                    </div>
                    <div class="card-body text-center"><h4>10</h4></div>
                </div>
            </div> --}}
            <div class="col-md-6">
                <div class="card card-info text-center">
                    <div class="card-header">
                        <div class="card-title">  Expense </div>
                    </div>
                    <div class="card-body">
                        <canvas id="expenseChart" width="400" height="200"></canvas>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title text-center">Vehicle Expenses</div>
                    </div>
                    <div class="card-body text-center">
                        <canvas id="vehicleExpensesChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">

            {{-- <div class="col-md-4">
                <div class="card card-success text-center">
                    <div class="card-header">
                        <div class="card-title">
                            Heading
                        </div>
                    </div>
                    <div class="card-body">
                        <p>This will be the detail shown here</p>
                    </div>
                    <div class="card-footer">Footer</div>
                </div>
            </div> --}}
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@push('scripts')
    <script>
        var ctx = document.getElementById('expenseChart').getContext('2d');
        var expenseChart = new Chart(ctx, {
            type: 'bar', // You can change this to 'line', 'pie', etc.
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Expenses',
                    data: @json($chartData['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

<script>
    const expensesData = @json($expenses);

    // Extract unique vehicles and expense types
    const plateNumbers = [...new Set(expensesData.map(expense => expense.plate_number))];
    const expenseTypes = [...new Set(expensesData.map(expense => expense.expense_type))];

    // Initialize an object to store expenses by vehicle and expense type
    const vehicleExpenses = {};

    plateNumbers.forEach(plate => {
        vehicleExpenses[plate] = {};
        expenseTypes.forEach(type => {
            vehicleExpenses[plate][type] = 0; // Initialize with 0
        });
    });

    // Populate the vehicle expenses object
    expensesData.forEach(expense => {
        vehicleExpenses[expense.plate_number][expense.expense_type] = expense.total_amount;
    });

    // Create datasets for each expense type
    const datasets = expenseTypes.map((type, index) => {
        return {
            label: type,
            data: plateNumbers.map(plate => vehicleExpenses[plate][type]),
            backgroundColor: `rgba(${(index + 1) * 50}, ${(index + 1) * 80}, ${(index + 1) * 100}, 0.5)`,
            borderColor: `rgba(${(index + 1) * 50}, ${(index + 1) * 80}, ${(index + 1) * 100}, 1)`,
            borderWidth: 1
        };
    });

    // Chart.js code to render the stacked bar chart
    const vehicle_expense_ctx = document.getElementById('vehicleExpensesChart').getContext('2d');
    const vehicleExpensesChart = new Chart(vehicle_expense_ctx, {
        type: 'bar',
        data: {
            labels: plateNumbers,  // Vehicle plate numbers
            datasets: datasets      // Expense type datasets
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Vehicle Expenses by Expense Type'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true,
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endpush
