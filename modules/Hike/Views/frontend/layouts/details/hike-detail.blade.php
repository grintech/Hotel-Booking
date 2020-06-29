<div class="g-header">
    <div class="left">
        <h2>{{$translation->title}}</h2>
        @if($translation->address)
            <p class="address"><i class="fa fa-map-marker"></i>
                {{$translation->address}}
            </p>
        @endif
    </div>
    <div class="right">
        @if(setting_item('hike_enable_review') and $review_score)
            <div class="review-score">
                <div class="head">
                    <div class="left">
                        <span class="head-rating">{{$review_score['score_text']}}</span>
                        <span class="text-rating">{{__("from :number reviews",['number'=>$review_score['total_review']])}}</span>
                    </div>
                    <div class="score">
                        {{$review_score['score_total']}}<span>/5</span>
                    </div>
                </div>
                <div class="foot">
                    {{__(":number% of guests recommend",['number'=>$row->recommend_percent])}}
                </div>
            </div>
        @endif
    </div>
</div>
@if(!empty($row->duration) or !empty($row->category_hike->name) or !empty($row->max_people) or !empty($row->location->name))
    <div class="g-tour-feature">
        <div class="row justify-content-between">
        @if($row->distance)
            <div class="col-md-5th-1 col-md-offset-0 col-sm-offset-2">
                <div class="item">
                    <div class="icon">
                        <img class="sand-clock-manage" style="width: 48px; height: 42px;" data-toggle="tooltip" data-placement="top" src="{{asset('icon/sand-clock.svg')}}" alt="sand-clock">
                        <!-- <i class="icofont-wall-clock"></i> -->
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Distance")}}</h4>
                        <p class="value">
                            @if($row->distance > 1)
                                {{ __(":number kilometers",array('number'=>$row->distance)) }}
                            @else
                                {{ __(":number kilometer",array('number'=>$row->distance)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if($row->duration)
            <div class="col-md-5th-1 col-md-offset-0 col-sm-offset-2">
                <div class="item">
                    <div class="icon">
                        <img class="sand-clock-manage" style="width: 48px; height: 42px;" data-toggle="tooltip" data-placement="top" src="{{asset('icon/tracking.svg')}}" alt="sand-clock">

                        <!-- <i class="icofont-beach"></i> -->
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Duration")}}</h4>
                        <p class="value">
                            @if($row->duration > 1)
                                {{ __(":number hours",array('number'=>$row->duration)) }}
                            @else
                                {{ __(":number hour",array('number'=>$row->duration)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if($row->ascent)
            <div class="col-md-5th-1 col-md-offset-0 col-sm-offset-2">
                <div class="item">
                    <div class="icon">
                        <img class="sand-clock-manage" style="width: 48px; height: 42px;" data-toggle="tooltip" data-placement="top" src="{{asset('icon/caret-up.svg')}}" alt="sand-clock">
                        <!-- <i class="icofont-travelling"></i> -->
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Ascent")}}</h4>
                        <p class="value">
                            @if($row->ascent > 1)
                                {{ __(":number meters",array('number'=>$row->ascent)) }}
                            @else
                                {{ __(":number meter",array('number'=>$row->ascent)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if($row->descent)
            <div class="col-md-5th-1 col-md-offset-0 col-sm-offset-2">
                <div class="item">
                    <div class="icon">
                        <img class="sand-clock-manage" style="width: 48px; height: 42px;" data-toggle="tooltip" data-placement="top" src="{{asset('icon/caret-down.svg')}}" alt="sand-clock">
                        <!-- <i class="icofont-travelling"></i> -->
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Descent")}}</h4>
                        <p class="value">
                            @if($row->descent > 1)
                                {{ __(":number meters",array('number'=>$row->descent)) }}
                            @else
                                {{ __(":number meter",array('number'=>$row->descent)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
        {{--@if($row->techniques)
            <div class="col-md-5th-1 col-md-offset-0 col-sm-offset-2">
                <div class="item">
                    <div class="icon">
                        <img class="sand-clock-manage" data-toggle="tooltip" data-placement="top" src="{{asset('icon/hill.svg')}}" alt="sand-clock">
                        <!-- <i class="icofont-travelling"></i> -->
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Technique")}}</h4>
                        <p class="value">
                            @if($row->techniques > 1)
                                {{ __(":number",array('number'=>$row->techniques)) }}
                            @else
                                {{ __(":number",array('number'=>$row->techniques)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif--}}
        @include('Hike::frontend.layouts.details.hike-attributes')
        </div>
    </div>
@endif
@if($row->getGallery())
    <div class="g-gallery">
        <div class="fotorama" data-width="100%" data-thumbwidth="135" data-thumbheight="135" data-thumbmargin="15" data-nav="thumbs" data-allowfullscreen="true">
            @foreach($row->getGallery() as $key=>$item)
                <a href="{{$item['large']}}" data-thumb="{{$item['thumb']}}"></a>
            @endforeach
        </div>
        <div class="social">
            <div class="social-share">
                <span class="social-icon">
                    <i class="icofont-share"></i>
                </span>
                <ul class="share-wrapper">
                    <li>
                        <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                            <i class="fa fa-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="twitter" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                            <i class="fa fa-twitter fa-lg"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                <i class="fa fa-heart-o"></i>
            </div>
        </div>
    </div>
@endif
@if($translation->content)
    <div class="g-overview">
        <h3>{{__("Overview")}}</h3>
        <div class="description">
            <?php echo $translation->content ?>
        </div>
    </div>
@endif
@include('Hike::frontend.layouts.details.hike-include-exclude')
@include('Hike::frontend.layouts.details.hike-itinerary')
@include('Hike::frontend.layouts.details.hike-attributes')
@include('Hike::frontend.layouts.details.hike-faqs')
@if($row->map_lat && $row->map_lng)
<div class="g-location">
    <div class="location-title">
        <h3>{{__("Hike Location")}}</h3>
        @if($translation->address)
            <div class="address">
                <i class="icofont-location-arrow"></i>
                {{$translation->address}}
            </div>
        @endif
    </div>

    <div class="location-map">
        <div id="map_content"></div>
    </div>
</div>
@endif
