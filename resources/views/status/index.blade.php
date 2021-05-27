@extends('layouts.master')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Create status</h6>
        </div>
        <div class="card-body">
            <form action="{{ !isset($status) ? route("status.store") : route("status.update", $status->id)}}" method="post" class="form-row">
                @csrf
                @isset($status)
                    @method('PUT')
                @endisset
                <div class="col-10">
                    <input type="text" placeholder="Name" name="name" class="form-control" required autocomplete="name" value="{{old('name', $status->name ?? '')}}" autofocus>
                </div>
                <div class="col-2">
                    <button typeof="submit" class="btn btn-block btn-outline-primary">
                        {{isset($status) ? 'Update' : 'Create'}}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Statuses</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-center">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center" width="50">№</th>
                        <th class="text-left">Name</th>
                        <th width="100">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($statuses as $k => $status)
                        <tr>
                            <th width="50">{{ ++$k }}</th>
                            <td class="text-left">{{$status->name}}</td>
                            <td>
                                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                    <a href="#" onclick="$(this).children('form').submit()"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        <form action="">
                                            <input type="hidden" name="change" value="1">
                                            <input type="hidden" name="status" value="{{$status->id}}">
                                        </form>
                                    </a>
                                    <a href="#" class="btn confirmDelete btn-outline-primary btn-sm" data-form="form{{$status->id}}">
                                        <i class="fas fa-trash"></i>
                                        <form action="{{ route('status.destroy', $status->id)}}" method="post" id="form{{$status->id}}">
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
