@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/hike/css/tour.css?_ver='.config('asset.hike.css')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
@endsection
@section('content')
    <div class="bravo_search_tour">
        <div class="bravo_banner" style="margin-top: -100px;padding-top: 140px;padding-bottom: 140px;" @if($bg = setting_item("hike_page_search_banner")) style="background-image: url({{get_file_url($bg,'full')}})" @endif >
            <div class="container">
                <h1>
                    {{setting_item_with_lang("hike_page_search_title")}}
                </h1>
            </div>
        </div>
        <div class="bravo_form_search">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @include('Hike::frontend.layouts.search.form-search')
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            @include('Hike::frontend.layouts.search.list-item')
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/hike/js/tour.js?_ver='.config('asset.hike.js')) }}"></script>
@endsection
