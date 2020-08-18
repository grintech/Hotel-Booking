@php
    $tour_related = $tour_related ? $tour_related->get() : [];
@endphp
@if(count($tour_related) > 0)
    <div class="bravo-list-hotel-related-widget">
        <h3 class="heading">{{ $item->title }}</h3>
        <div class="list-item">
            @foreach($tour_related as $tour)
                @php $translation = $tour->translateOrOrigin(app()->getLocale()) @endphp
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ $tour->getDetailUrl(app()->getLocale()) }}">
                                @if($image_url = get_file_url($tour->image_id, 'thumb'))
                                    <a href="{{ $tour->getDetailUrl(app()->getLocale()) }}">
                                        {!! get_image_tag($tour->image_id,'thumb',['class'=>'','alt'=>$tour->title]) !!}
                                    </a>
                                @endif
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="{{ $tour->getDetailUrl(app()->getLocale()) }}">
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
