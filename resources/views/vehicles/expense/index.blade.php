@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="content-header card">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Vehicle Expenses</h1>
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
                        <a class="btn btn-md btn-success mr-2" href="{{ route('vehicle.expense.new') }}">Add Expense</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead class="bg-dark">
                    <tr>
                        <th>Si:No</th>
                        <th>Vehicle Number</th>
                        <th class="col-3">Expense</th>
                        <th class="col-3">Date</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="bg-info">
                        <form action="{{route('vehicle.expense.index')}}" id="expense_filter_form" method="get">
                            @csrf
                            <td><label class="form-label">Search</label></td>
                            <td>
                                <select name="vehicle_id" id="vehicle_id" class="form-control form-control-sm">
                                    <option value="">Plate Number</option>
                                    @forelse ($fleets as $fleet)
                                        <option value="{{$fleet->id}}"> {{$fleet->plate_number}}</option>
                                    @empty
                                        <option value=""> {--No Data Found--}</option>
                                    @endforelse
                                </select>
                            </td>
                            <td>
                                <select name="expense_id" id="expense_id" class="form-control form-control-sm">
                                    <option value="">Expense Type</option>
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
                                        <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"/>
                                    </div>
                                </div>
                            </td>
                            <td><button id="expense_filter_form_submit" class="btn btn-md btn-dark">Search</button></td>
                        </form>
                    </tr>
                </thead>
                <tbody>
                    @php //dd($expenses); @endphp
                    @forelse($expenses as $expense)    
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $expense->vehicle->plate_number ?? '-' }}</td>
                        <td>{{ $expense->expenseType->name ?? '-' }}</td>
                        <td>{{ $expense->created_at }}</td>
                        <td>
                            <a href="{{route('vehicle.expense.view',['expense_id'=>$expense->id])}}" class="btn btn-sm btn-primary">View</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center"><p class="text-center text-warning">No Vehicle found</p></td>
                    </tr>
                    @endforelse                
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="5">
                        <div class="pagination justify-content-center">
                            {{ $expenses->links('vendor.pagination.bootstrap-4') }}
                        </div>

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
