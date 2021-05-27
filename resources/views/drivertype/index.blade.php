@extends('layouts.master')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Create DriverType</h6>
        </div>
        <div class="card-body">
            <form action="{{ !isset($driver_type) ? route("drivertype.store") : route("drivertype.update", $driver_type->id)}}"
                  method="post" class="form-row">
                @csrf
                @isset($driver_type)
                    @method('PUT')
                @endisset
                <div class="col-10">
                    <input type="text" placeholder="Name" name="name" class="form-control" required autocomplete="name"
                           value="{{old('name', $driver_type->name ?? '')}}" autofocus>
                </div>
                <div class="col-2">
                    <button typeof="submit" class="btn btn-block btn-outline-primary">
                        {{isset($driver_type) ? 'Update' : 'Create'}}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DriverTypes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-center">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center" width="50">№</th>
                        <th>Name</th>
                        <th width="100">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($driver_types as $k => $driver_type)
                        <tr>
                            <th width="50">{{ $k + 1 }}</th>
                            <td class="text-left">{{$driver_type->name}}</td>
                            <td>
                                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                    <a href="#" onclick="$(this).children('form').submit()"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        <form action="">
                                            <input type="hidden" name="change" value="1">
                                            <input type="hidden" name="driverType" value="{{$driver_type->id}}">
                                        </form>
                                    </a>
                                    <a href="#" class="btn confirmDelete btn-outline-primary btn-sm" data-form="form{{$driver_type->id}}">
                                        <i class="fas fa-trash"></i>
                                        <form action="{{ route('drivertype.destroy', $driver_type->id)}}" method="post" id="form{{$driver_type->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No data found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
