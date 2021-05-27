@extends('layouts.master')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-content-center">
            <h6 class="m-0 font-weight-bold text-primary">Users </h6>
            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                    data-target=".bd-example-modal-sm">Create
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped text-center">
                    <thead class="thead-light">
                    <tr>
                        <th width="50">№</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Telegram User ID</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $k => $user)
                        <tr>
                            <th width="50">{{ $k + 1 }}</th>
                            <td class="text-left">{{$user->roles->name ?? ' - '}}</td>
                            <td class="text-left">{{$user->name}}</td>
                            <td class="text-left">{{$user->email}}</td>
                            <td class="text-left">{{$user->telegram_user_id}}</td>
                            <td>
                                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                    <a href="#" class="btn confirmDelete btn-outline-primary btn-sm"
                                       data-form="form{{$user->id}}">
                                        <i class="fas fa-trash"></i>
                                        <form action="{{ route('user.destroy', $user->id)}}" method="post"
                                              id="form{{$user->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No data found</td>
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
                <form method="post" action="{{ route("user.store") }}">
                    @csrf
                    <div class="form-group">
                        <label>Role <sup class="text-danger">*</sup></label>
                        <select name="role_id" class="form-control form-control-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Company</label>
                        <select name="company_id" class="form-control form-control-sm">
                            <option>Выбрать</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control form-control-sm" name="username">
                    </div>
                    <div class="form-group">
                        <label>Email <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control form-control-sm" name="email">
                    </div>
                    <div class="form-group">
                        <label>Password <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label>Telegram User Id:</label>
                        <input type="text" class="form-control form-control-sm" name="telegramuserid">
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
