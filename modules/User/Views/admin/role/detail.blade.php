@extends('admin.layouts.app')
@section('content')
    <form action="" method="post">
        @csrf
        <div class="container">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? 'Edit: '.$row->name : 'Add new role'}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">
                            <h3 class="panel-body-title">{{ __('Role Content')}} </h3>
                            <div class="form-group">
                                <label>{{ __('Name')}}</label>
                                <input type="text" value="{{$row->name}}" placeholder="{{ __('Role Name')}}" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Default service for vendor dashboard')}}</label>
                                <select name="service" value="{{ $row->service }}" class="form-control">
                                    @php
                                        $services = get_bookable_services();
                                    @endphp
                                    @foreach($services as $service_name => $className)
                                        <option value="{{ $service_name }}">{{ $service_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>&nbsp;</span>
                        <button class="btn btn-primary" type="submit">{{ __('Save Change')}}</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
@section ('script.body')
@endsection
