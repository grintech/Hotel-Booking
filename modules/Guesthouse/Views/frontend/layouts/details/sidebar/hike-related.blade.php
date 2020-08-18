@php
    $hike_related = $hike_related ? $hike_related->get() : [];
@endphp
@if(count($hike_related) > 0)
    <div class="bravo-list-hotel-related-widget">
        <h3 class="heading">{{ $item->title }}</h3>
        <div class="list-item">
            @foreach($hike_related as $hike)
                @php $translation = $hike->translateOrOrigin(app()->getLocale()) @endphp
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ $hike->getDetailUrl(app()->getLocale()) }}">
                                @if($image_url = get_file_url($hike->image_id, 'thumb'))
                                    <a href="{{ $hike->getDetailUrl(app()->getLocale()) }}">
                                        {!! get_image_tag($hike->image_id,'thumb',['class'=>'','alt'=>$hike->title]) !!}
                                    </a>
                                @endif
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="{{ $hike->getDetailUrl(app()->getLocale()) }}">
                                    {{$translation->title}}
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
