

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
                    <a class="btn btn-md btn-success mr-2" href="{{ route('vehicles.create') }}">Add New Vehicle</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="bg-dark">
                <tr>
                    <th colspan="2">Vehicle Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-2"> Plate Number :</td> <td>{{$vehicle->plate_number}}</td>
                </tr>
                <tr>
                    <td> Fuel :</td> <td>{{$vehicle->fuel}}</td>
                </tr>
                <tr>
                    <td> Description :</td> <td>{{$vehicle->description}}</td>
                </tr>  
            </tbody>
            <tfoot>
                <tr colspan="2">
                    <td  class=" col-12 float-right">
                        <a href="{{route('vehicles.index')}}" class="btn btn-md btn-secondary">Back</a>
                        <a href="{{route('vehicles.edit',['vehicle'=>$vehicle->id])}}" class="btn btn-md btn-warning">Edit</a>
                        <a href="#" class="btn btn-md btn-danger">Delete</a>
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


