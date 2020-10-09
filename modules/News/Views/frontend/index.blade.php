@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/news/css/news.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/css/app.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>

    <style type="text/css">
        .bravo-contact-block .section{
            padding: 80px 0 !important;
        }

        .bravo_header.fixed-top{
            background-color: white;
        }

        .bravo_wrap .bravo_header .content .header-left .bravo-menu ul li a{
            transition: all .2s ease-out;
            color: #1a2b48;
            text-transform: none;
            font-weight: bold;
        }

        .bravo_header .content img{
            max-height: 65px;
            filter: unset;
        }

        .bravo_header .container-fluid{
            background-color: white;
            box-shadow: 1px 0 1px #1a2b48;
            /*box-shadow: 2px 3px 8px rgba(0,0,0,.1);*/
        }
    </style>
@endsection
@section('content')
    <div class="bravo-news">
        @php
            $title_page = setting_item_with_lang("news_page_list_title");
            if(!empty($custom_title_page)){
                $title_page = $custom_title_page;
            }
        @endphp
        @if(!empty($title_page))
            <div class="bravo_banner" @if($bg = setting_item("news_page_list_banner")) style="background-image: url({{get_file_url($bg,'full')}})" @endif >
                <div class="container">
                    <h1>
                        {{ $title_page }}
                    </h1>
                </div>
            </div>
        @endif
        @include('News::frontend.layouts.details.news-breadcrumb')
        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        @if($rows->count() > 0)
                            <div class="list-news">
                                @include('News::frontend.layouts.details.news-loop')
                                <hr>
                                <div class="bravo-pagination">
                                    {{$rows->appends(request()->query())->links()}}
                                    <span class="count-string">{{ __("Showing :from - :to of :total posts",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                {{__("Sorry, but nothing matched your search terms. Please try again with some different keywords.")}}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        @include('News::frontend.layouts.details.news-sidebar')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


