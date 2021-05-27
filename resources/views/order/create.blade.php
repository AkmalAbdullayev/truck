@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="h5 mb-0">Create order</div>
        </div>
        <div class="card-body">
            <form method="post" class="form-row" action="{{ route("order.store") }}">
                @csrf
                <div class="col-6">
                    <div class="form-group">
                        <label>Source <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control form-control-sm" name="source" required value="{{old('source')}}">
                    </div>
                    <div class="form-group">
                        <label>Pickup Time <sup class="text-danger">*</sup></label>
                        <input type="datetime-local" class="form-control form-control-sm" name="pickup_time" value="{{old('pickup_time')}}" required>
                    </div>
                    <div class="form-group">
                        <label>Weight </label>
                        <input type="number" class="form-control form-control-sm" name="weight" value="{{old('weight')}}">
                    </div>
                    <div class="form-group">
                        <label>Load №</label>
                        <input type="text" class="form-control form-control-sm" name="load_number" required value="{{old('load_number')}}">
                    </div>
                    <div class="form-group">
                        <label>Status <sup class="text-danger">*</sup></label>
                        <select name="status_id" class="form-control form-control-sm" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>From <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control form-control-sm" name="from" required value="{{old('from')}}">
                    </div>
                    <div class="form-group">
                        <label>To <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control form-control-sm" name="to" required value="{{old('to')}}">
                    </div>
                    <div class="form-group">
                        <label>Commodity <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control form-control-sm" name="commodity" value="{{old('commodity')}}">
                    </div>
                    <div class="form-group">
                        <label>Drive price </label>
                        <input type="number" class="form-control form-control-sm" name="drive_price" value="{{old('drive_price')}}">
                    </div>
                    <div class="form-group">
                        <label>Bol Image</label>
                        <input type="text" class="form-control form-control-sm" name="bol_image">
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
