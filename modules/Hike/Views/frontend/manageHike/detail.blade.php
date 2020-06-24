@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <h2 class="title-bar no-border-bottom">
        {{$row->id ? __('Edit: ').$row->title : __('Add new hike')}}
    </h2>
    @include('admin.message')
    @if($row->id)
        @include('Language::admin.navigation')
    @endif
    <div class="lang-content-box">
        <form action="{{route('hike.vendor.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
            @csrf
            <div class="form-add-service">
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a data-toggle="tab" href="#nav-tour-content" aria-selected="true" class="active">{{__("1. Content")}}</a>
                    <a data-toggle="tab" href="#nav-tour-location" aria-selected="false">{{__("2. Locations")}}</a>
                    @if(is_default_lang())
                        <a data-toggle="tab" href="#nav-tour-pricing" aria-selected="false">{{__("3. Pricing")}}</a>
                        <a data-toggle="tab" href="#nav-availability" aria-selected="false">{{__("4. Availability")}}</a>
                        <a data-toggle="tab" href="#nav-attribute" aria-selected="false">{{__("5. Attributes")}}</a>
                        <a data-toggle="tab" href="#nav-ical" aria-selected="false">{{__("6. Ical")}}</a>
                    @endif
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-tour-content">
                        @include('Hike::admin.hike.hike-content')
                        @if(is_default_lang())
                            <div class="form-group">
                                <label>{{__("Featured Image")}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="nav-tour-location">
                        @include('Hike::admin.hike.hike-location',["is_smart_search"=>"1"])
                    </div>
                    @if(is_default_lang())
                        <div class="tab-pane fade" id="nav-tour-pricing">
                            <div class="panel">
                                <div class="panel-title"><strong>{{__('Default State')}}</strong></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select name="default_state" class="custom-select">
                                                    <option value="">{{__('-- Please select --')}}</option>
                                                    <option value="1" @if(old('default_state',$row->default_state ?? 0) == 1) selected @endif>{{__("Always available")}}</option>
                                                    <option value="0" @if(old('default_state',$row->default_state ?? 0) == 0) selected @endif>{{__("Only available on specific dates")}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('Hike::admin.hike.pricing')
                        </div>
                        <div class="tab-pane fade" id="nav-availability">
                            @include('Hike::admin.hike.availability')
                        </div>
                        <div class="tab-pane fade" id="nav-attribute">
                            @include('Hike::admin.hike.attributes')
                        </div>
                        <div class="tab-pane fade" id="nav-ical">
                            @include('Hike::admin.hike.ical')
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
            </div>
        </form>
    </div>
@endsection
@section('footer')
    <script type="text/javascript" src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/condition.js?_ver='.config('app.version')) }}"></script>
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            new BravoMapEngine('map_content', {
                fitBounds: true,
                center: [{{$row->map_lat ?? "51.505"}}, {{$row->map_lng ?? "-0.09"}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    @if($row->map_lat && $row->map_lng)
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {}
                    });
                    @endif
                    engineMap.on('click', function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                    engineMap.on('zoom_changed', function (zoom) {
                        $("input[name=map_zoom]").attr("value", zoom);
                    });
                    engineMap.searchBox($('.bravo_searchbox'),function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                }
            });
        })
    </script>
@endsection