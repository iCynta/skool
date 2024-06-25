@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Vehicle Master</li>
                    <li class="breadcrumb-item">Vehicles</li>
                    <li class="breadcrumb-item active">New</li>
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
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Edit Vehicle</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('vehicles.update', $vehicle->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Plate Number</label>
                                    <input type="text" name="plate_number" class="form-control" id="plate_number"
                                        required="true" readonly="true" placeholder="Vehicle Number" max="20" value="{{$vehicle->plate_number}}">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="5">{{$vehicle->description}}</textarea>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="affiliation_no">Fuel Type</label>
                                    <select name="fuel" id="fuel" class="form-control">
                                        <option value="diesel">Diesel</option>
                                        <option value="petrol">Petrol</option>
                                        <option value="electric">Electric</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection