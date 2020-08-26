@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/hike/css/tour.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endsection
@section('content')
    <div class="bravo_detail_tour">
        @include('Hike::frontend.layouts.details.hike-banner')
        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        @php $review_score = $row->review_data @endphp
                        @include('Hike::frontend.layouts.details.hike-detail')
                        @include('Hike::frontend.layouts.details.hike-review')
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="" style="position: sticky; position: -webkit-sticky; top: 100px;">
                            @include('Tour::frontend.layouts.details.vendor')
                            @include('Hike::frontend.layouts.details.sidebar')
{{--                            @include('Tour::frontend.layouts.details.guesthouse-related')--}}
                            {{--                        @include('Hike::frontend.layouts.details.hike-form-book')--}}
                            {{--                        @include('Hike::frontend.layouts.details.open-hours')--}}
                        </div>
                    </div>
                </div>
                <div class="row end_tour_sticky">
                    <div class="col-md-12">
                        @include('Hike::frontend.layouts.details.hike-related')
                    </div>
                </div>
            </div>
        </div>
        <div class="bravo-more-book-mobile">
            <div class="container">
                <div class="left">
                    <div class="g-price">
                        <div class="prefix">
                            <span class="fr_text">{{__("from")}}</span>
                        </div>
                        <div class="price">
                            <span class="onsale">{{ $row->display_sale_price }}</span>
                            <span class="text-price">{{ $row->display_price }}</span>
                        </div>
                    </div>
                    @if(setting_item('hike_enable_review'))
                    <?php
                    $reviewData = $row->getScoreReview();
                    $score_total = $reviewData['score_total'];
                    ?>
                    <div class="service-review tour-review-{{$score_total}}">
                        <div class="list-star">
                            <ul class="booking-item-rating-stars">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                            </ul>
                            <div class="booking-item-rating-stars-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                                <ul class="booking-item-rating-stars">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                        <span class="review">
                        @if($reviewData['total_review'] > 1)
                                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                            @else
                                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                            @endif
                    </span>
                    </div>
                    @endif
                </div>
                <div class="right">
                    <a class="btn btn-primary bravo-button-book-mobile">{{__("Book Now")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    @if(setting_item('map_provider') == "osm")
        <script src="{{ asset('js/gpx-parser.js') }}"></script>
        <script type="application/javascript">
            function display_gpx(elt) {
                if (!elt) return;

                var url = '{{ asset("$translation->gpx_file") }}';

                var map = L.map('map_content');
                map.scrollWheelZoom.disable();
                L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
                }).addTo(map);

                var control = L.control.layers(null, null).addTo(map);

                new L.GPX(url, {
                    async: true,
                    marker_options: {
                        startIconUrl: '{{ asset('icon/markers/pin-icon-start.png') }}',
                        endIconUrl:   '{{ asset('icon/markers/pin-icon-end.png') }}',
                        shadowUrl:    '{{ asset('icon/markers/pin-shadow.png') }}',
                    },
                }).on('loaded', function(e) {
                    var gpx = e.target;
                    map.fitBounds(gpx.getBounds());
                    control.addOverlay(gpx, gpx.get_name());
                }).addTo(map);
            }
            display_gpx(document.getElementById('map_content'));
        </script>
    @else
        <script src="{{ asset('js/loadgpx.js') }}"></script>
        <script type="text/javascript">

            var map;
            $(function(){
                initializeMap('{{ asset("$translation->gpx_file") }}');
            });

            function initializeMap(gpxFile) {

                var mapOptions = {
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map_content"), mapOptions);
                google.maps.event.trigger(map, "resize");
                loadGPXFileIntoGoogleMap(gpxFile);
            };

            function loadGPXFileIntoGoogleMap(filename) {
                // alert(filename);
                $.ajax({url: filename,
                    dataType: "xml",
                    success: function(data) {
                        var parser = new GPXParser(data, map);
                        console.log(parser);
                        parser.setTrackColour("#ff0000");
                        parser.setTrackWidth(5);
                        parser.setMinTrackPointDelta(0.001);
                        parser.centerAndZoom(data);
                        parser.addTrackpointsToMap();
                        parser.addWaypointsToMap();
                    }
                });
            }

        </script>
    @endif
    <script>
        var bravo_booking_data = {!! json_encode($booking_data) !!}
        var bravo_booking_i18n = {
                no_date_select:'{{__('Please select Start date')}}',
                no_guest_select:'{{__('Please select at least one guest')}}',
                load_dates_url:'{{route('hike.vendor.availability.loadDates')}}',
                name_required:'{{ __("Name is Required") }}',
                email_required:'{{ __("Email is Required") }}',
            };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/hike/js/single-tour.js?_ver='.config('app.version')) }}"></script>
@endsection
