@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-10">All</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">75</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">On processing
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">40</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Finished</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">25</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->user()->roles->name != "admin")
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Orders without
                                    BOL
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
            <a href="{{route('order.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-center">
                    <thead class="thead-light">
                    <tr>
                        <th width="50">№</th>
                        <th width="100">Action</th>
                        <th class="min-w-200">Load №</th>
                        <th class="min-w-150">Status</th>
                        <th class="min-w-150">User</th>
                        <th class="min-w-150">PickupTime</th>
                        <th class="min-w-150">Call History</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $k => $order)
                        <tr>
                            <th width="50">{{ $k + 1 }}</th>
                            <td width="100">
                                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                    <a href="" title="Открыть" class="btn btn-outline-primary btn-sm openProducts">
                                        <i aria-hidden="true" class="fa fa-folder-open"></i>
                                    </a>
                                    <a href="{{ route('order.edit', $order->id)}}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="#" data-form="order{{$order->id}}"
                                       class="btn confirmDelete btn-outline-primary btn-sm">
                                        <i class="fas fa-trash"></i>
                                        <form action="{{ route('order.destroy', $order->id)}}" method="post" id="order{{$order->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </a>
                                </div>
                            </td>
                            <td>{{$order->load_number}}</td>
                            <td><span class="badge badge-pill badge-info">{{$order->status->name ?? ''}}</span></td>
                            <td>{{$order->users->name ?? ''}}</td>
                            <td>{{$order->pickup_time}}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-container="body"
                                        data-toggle="popover" data-placement="left"
                                        data-content="Called time, Play call audio">
                                    <i class="fas fa-phone-volume"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="child-elements" style="display: none">
                            <td colspan="8">
                                <table class="table-sm table table-bordered mb-0">
                                    <thead class="bg-gray-100">
                                    <tr>
                                        <th class="min-w-150">Source</th>
                                        <th class="min-w-100">From</th>
                                        <th class="min-w-100">To</th>
                                        <th class="min-w-150">Commodity</th>
                                        <th class="min-w-150">Weight</th>
                                        <th class="min-w-150">DrivePrice</th>
                                        <th class="min-w-150">Bol Image</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <td>{{$order->source}}</td>
                                    <td>{{$order->from}}</td>
                                    <td>{{$order->to}}</td>
                                    <td>{{$order->commodity}}</td>
                                    <td>{{$order->weight}}</td>
                                    <td>{{$order->drive_price}}</td>
                                    <td>{{$order->bol_image}}</td>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No data found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
