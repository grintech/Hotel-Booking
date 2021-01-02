@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="item-loop {{$wrap_class ?? ''}}">
    @if($is_more_item ?? false)
        <div style="z-index: 20;position: absolute;top: 0;left: 0;right: 0;bottom: 0;background: rgba(255, 255, 255, 0.2);backdrop-filter: blur(6px);display: flex;flex-direction: column;justify-content: center;align-items: center;text-align: center;padding: 16px;">
            <p class="text-light">{{ $view_more_desc }}</p>
            <a href="{{ route('guesthouse.search') }}" class="shadow btn btn-primary">{{ __('Browse More') }}</a>
        </div>
    @endif
    @if($row->is_featured == "1")
        <div class="featured">
            {{__("Featured")}}
        </div>
    @endif
    <div class="thumb-image ">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}">
            @if($row->image_url)
                @if(!empty($disable_lazyload))
                    <img src="{{$row->image_url}}" class="img-responsive" alt="">
                @else
                    {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$translation->title]) !!}
                @endif
            @endif
        </a>
        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <i class="fa fa-heart"></i>
        </div>
    </div>
    <div class="item-title">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}">
            @if($row->is_instant)
                <i class="fa fa-bolt d-none"></i>
            @endif
            {{$translation->title}}
        </a>
        @if($row->discount_percent)
            <div class="sale_info">{{$row->discount_percent}}</div>
        @endif
    </div>
    <div class="location">
        @if(!empty($row->location->name))
            @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
            {{$location->name ?? ''}}
        @endif
    </div>
    @if(setting_item('guesthouse_enable_review'))
    <?php
    $reviewData = $row->getScoreReview();
    $score_total = $reviewData['score_total'];
    ?>
    <div class="service-review">
        <span class="rate">
            @if($reviewData['total_review'] > 0) {{$score_total}}/5 @endif <span class="rate-text">{{$reviewData['review_text']}}</span>
        </span>
        <span class="review">
             @if($reviewData['total_review'] > 1)
                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
            @else
                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
            @endif
        </span>
    </div>
    @endif
    <div class="info">
        <div class="g-price">
            <div class="prefix">
                <span class="fr_text">{{__("from")}}</span>
            </div>
            <div class="price">
                <span class="text-price">{{ $row->display_price }} <span class="unit">{{__("/night")}}</span></span>
            </div>
        </div>
    </div>
</div>
