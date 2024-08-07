

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
                    <a class="btn btn-md btn-success mr-2" href="{{ route('vehicles.create') }}">Add New Vehicle</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead class="bg-dark">
                <tr>
                    <th> Si:No</th>
                    <th> Vehicle Number</th>
                    <th> Actions</th>
                </tr>
            </thead>
            <tbody>
            @php //dd($vehicles); @endphp
                @forelse($vehicles as $vehicle)
                <tr>
                    <td> {{ $loop->index + 1 }} </td>
                    <td> {{ $vehicle->plate_number }} </td>
                    <td> 
                        <a href="{{route('vehicles.show',['vehicle'=>$vehicle->id])}}" class="btn btn-sm btn-primary">VIEW</a>
                        <a href="{{route('vehicles.edit',['vehicle'=>$vehicle->id])}}" class="btn btn-sm btn-warning">EDIT</a>
                        <a href="#" class="btn btn-sm btn-danger">DELETE</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center"><p class="text-center text-warning"> No Vehicle found </p></td></tr>
                @endforelse
            </tbody>
            <tfoot class="bg-light">
                    <tr>
                        <td colspan="5">
                        <div class="pagination justify-content-center">
                            {{ $vehicles->links('vendor.pagination.bootstrap-4') }}
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


