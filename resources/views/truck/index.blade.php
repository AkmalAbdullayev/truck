@extends('layouts.master')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Trucks </h6>
            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                    data-target=".bd-example-modal-sm">Create
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center table-sm table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center" width="50">#</th>
                        <th>Name</th>
                        <th>Plate number</th>
                        <th>Info</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($trucks as $k => $truck)
                        <tr>
                            <th width="50">{{ ++$k }}</th>
                            <td>{{$truck->name}}</td>
                            <td>{{$truck->plate_number}}</td>
                            <td>{{$truck->info}}</td>
                            <td width="100">
                                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                    <a href="" data-toggle="modal" data-target=".bd-example-modal-sm-edit{{$truck->id}}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" data-form="truck{{$truck->id}}"
                                       class="btn confirmDelete btn-outline-primary btn-sm">
                                        <i class="fas fa-trash"></i>
                                        <form action="{{ route('truck.destroy', $truck->id)}}" method="post" id="truck{{$truck->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </a>
                                </div>
                                <div class="modal fade bd-example-modal-sm-edit{{$truck->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-4 text-left">
                                            <form method="post" action="{{ route("truck.update", $truck->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label>Name <sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control form-control-sm" name="name" value="{{$truck->name}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Plate №</label>
                                                    <input type="text" class="form-control form-control-sm" name="plate_number" value="{{$truck->plate_number}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Info</label>
                                                    <input type="text" class="form-control form-control-sm" name="info" value="{{$truck->info}}">
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
                        <tr><td colspan="6">No data found</td></tr>
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
                <form method="post" action="{{ route("truck.store") }}">
                        @csrf
                        <div class="form-group">
                            <label>Name <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control form-control-sm" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Plate №</label>
                            <input type="text" class="form-control form-control-sm" name="plate_number" >
                        </div>
                        <div class="form-group">
                            <label>Info</label>
                            <input type="text" class="form-control form-control-sm" name="info" >
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Create</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection
