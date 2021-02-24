@php
    $translation = $row->translateOrOrigin(app()->getLocale());
    $is_more_view = $is_more_item ?? false;
@endphp
<div class="item-tour {{$wrap_class ?? ''}}">
    @if($is_more_view)
        <div style="z-index: 20;position: absolute;top: 0;left: 0;right: 0;bottom: 0;background: rgba(255, 255, 255, 0.2);backdrop-filter: blur(6px);display: flex;flex-direction: column;justify-content: center;align-items: center;text-align: center;padding: 16px;">
            <p class="text-light">{{ $view_more_desc }}</p>
            <a href="{{ route('hike.search') }}" class="shadow btn btn-primary">{{ __('Browse More') }}</a>
        </div>
    @endif
    @if($row->is_featured == "1")
        <div class="featured">
            {{__("Featured")}}
        </div>
    @endif
    <div class="thumb-image">
        @if($row->discount_percent)
            <div class="sale_info">{{$row->discount_percent}}</div>
        @endif
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
            @if($row->image_url)
                @if(!empty($disable_lazyload))
                    <img src="{{$row->image_url}}" class="img-responsive" alt="{{$location->name ?? ''}}">
                @else
                    {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
                @endif
            @endif
        </a>
        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <i class="fa fa-heart"></i>
        </div>
    </div>
    <div class="location">
        @if(!empty($row->location->name))
            @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
            <i class="icofont-paper-plane"></i>
            {{$location->name ?? ''}}
        @endif
    </div>
    <div class="item-title">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
            {!! clean($translation->title) !!}
        </a>
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
