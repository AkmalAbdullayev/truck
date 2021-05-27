@extends('layouts.master')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Drivers</h6>
            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                    data-target=".bd-example-modal-sm">Create
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-center">
                    <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Name</th>
                        <th width="200">DriverType</th>
                        <th width="100">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($drivers as $k => $driver)
                        <tr>
                            <th width="50">{{ $k + 1 }}</th>
                            <td class="text-left">{{$driver->name}}</td>
                            <td>{{$driver->drivertypes->name ?? ''}}</td>
                            <td>
                                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                    <a href="" data-toggle="modal" data-target=".bd-example-modal-sm-edit{{$driver->id}}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" data-form="form{{$driver->id}}"
                                       class="btn confirmDelete btn-outline-primary btn-sm">
                                        <i class="fas fa-trash"></i>
                                        <form action="{{ route('driver.destroy', $driver->id)}}" method="post" id="form{{$driver->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </a>
                                </div>
                                <div class="modal fade bd-example-modal-sm-edit{{$driver->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-4 text-left">
                                            <form method="post" action="{{ route("driver.update", $driver->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label>Name <sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control form-control-sm" name="name" value="{{$driver->name}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>DriverType <sup class="text-danger">*</sup></label>
                                                    <select name="driver_type_id" class="form-control form-control-sm">
                                                        @foreach($driver_types as $driver_type)
                                                            <option value="{{ $driver_type->id }}" {{$driver->driver_type_id == $driver_type->id ? 'selected' : ''}}>{{ $driver_type->name }}</option>
                                                        @endforeach
                                                    </select>
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
                            <td colspan="4">No data found</td>
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
                <form method="post" action="{{ route("driver.store") }}">
                    @csrf
                    <div class="form-group">
                        <label>DriverType <sup class="text-danger">*</sup></label>
                        <select name="driver_type_id" class="form-control form-control-sm">
                            @foreach($driver_types as $driver_type)
                                <option value="{{ $driver_type->id }}">{{ $driver_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control form-control-sm" name="name">
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-outline-primary btn-sm">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
