@extends('layouts.master')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Create company</h6>
        </div>
        <div class="card-body">
            <form action="{{ !isset($company) ? route("company.store") : route("company.update", $company->id)}}" method="post" class="form-row">
                @csrf
                @isset($company)
                    @method('PUT')
                @endisset
                <div class="col-10">
                    <input type="text" placeholder="Name" name="name" class="form-control" required autocomplete="name" value="{{old('name', $company->name ?? '')}}" autofocus>
                </div>
                <div class="col-2">
                    <button typeof="submit" class="btn btn-block btn-outline-primary">
                        {{isset($company) ? 'Update' : 'Create'}}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of Companies</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered text-center">
                        <thead class="thead-light">
                        <tr>
                            <th width="50">#</th>
                            <th class="text-left">Name</th>
                            <th width="200">Status</th>
                            <th width="100">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($companies as $k => $company)
                            <tr>
                                <th>{{ ++$k }}</th>
                                <td class="text-left">{{$company->name}}</td>
                                <td>
                                    <form>
                                        <input type="hidden" name="company" value="{{$company->id}}">
                                        <select name="status" class="form-control-sm form-control w-50 m-auto" onchange="$(this).closest('form').submit()">
                                            <option value="1" {{$company->status == 1 ? 'selected' : ''}}>Enabled</option>
                                            <option value="0" {{$company->status == 0 ? 'selected' : ''}}>Disabled</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                        <a href="#" onclick="$(this).children('form').submit()"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                            <form action="">
                                                <input type="hidden" name="change" value="1">
                                                <input type="hidden" name="company" value="{{$company->id}}">
                                            </form>
                                        </a>
                                        <a href="#" class="btn confirmDelete btn-outline-primary btn-sm" data-form="form{{$company->id}}">
                                            <i class="fas fa-trash"></i>
                                            <form action="{{ route('company.destroy', $company->id)}}" method="post" id="form{{$company->id}}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
