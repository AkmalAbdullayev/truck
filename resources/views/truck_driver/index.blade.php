@extends('layouts.master')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Truck Drivers</h6>
        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                data-target=".bd-example-modal-sm">Create
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm text-center table-bordered">
                <thead class="thead-light">
                <tr>
                    <th class="text-center" width="50">№</th>
                    <th>Truck name</th>
                    <th>Driver name</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($truck_drivers as $k => $truck_driver)
                    <tr>
                        <th width="50">{{ $k + 1 }}</th>
                        <td>{{$truck_driver->trucks->name ?? ''}}</td>
                        <td>{{$truck_driver->drivers->name ?? ''}}</td>
                        <td>{{$truck_driver->date}}</td>
                        <td width="100">
                            <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                <a href="" data-toggle="modal" data-target=".bd-example-modal-sm-edit{{$truck_driver->id}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" data-form="truck{{$truck_driver->id}}"
                                   class="btn confirmDelete btn-outline-primary btn-sm">
                                    <i class="fas fa-trash"></i>
                                    <form action="{{ route('truckdriver.destroy', $truck_driver->id)}}" method="post" id="truck{{$truck_driver->id}}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </a>
                            </div>
                            <div class="modal fade bd-example-modal-sm-edit{{$truck_driver->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content p-4 text-left">
                                        <form method="post" action="{{ route("truckdriver.update", $truck_driver->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label>Driver <sup class="text-danger">*</sup></label>
                                                <select name="driver_id" class="form-control form-control-sm">
                                                    @foreach($drivers as $driver)
                                                        <option value="{{ $driver->id }}" {{$driver->id == $truck_driver->driver_id ? 'selected' : ''}}>{{ $driver->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Truck <sup class="text-danger">*</sup></label>
                                                <select name="truck_id" class="form-control form-control-sm">
                                                    @foreach ($trucks as $truck)
                                                        <option value="{{ $truck->id }}" {{$truck->id == $truck_driver->truck_id ? 'selected' : ''}}>{{ $truck->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input type="date" class="form-control form-control-sm" name="date" value="{{$truck_driver->date}}" required>
                                            </div>
                                            <div class="form-group mb-0 text-center">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No data found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <form method="post" action="{{ route("truckdriver.store") }}">
                @csrf
                <div class="form-group">
                    <label>Driver <sup class="text-danger">*</sup></label>
                    <select name="driver_id" class="form-control form-control-sm">
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Truck <sup class="text-danger">*</sup></label>
                    <select name="truck_id" class="form-control form-control-sm">
                        @foreach ($trucks as $truck)
                            <option value="{{ $truck->id }}">{{ $truck->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control form-control-sm" name="date">
                </div>
                <div class="form-group mb-0 text-center">
                    <button type="submit" class="btn btn-outline-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
