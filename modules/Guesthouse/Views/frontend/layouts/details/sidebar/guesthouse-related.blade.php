@if(count($guesthouse_related) > 0)
    <div class="bravo-list-hotel-related-widget">
        <h3 class="heading">{{ $item->title }}</h3>
        <div class="list-item">
            @foreach($guesthouse_related as $guesthouse)
                @php $translation = $guesthouse->translateOrOrigin(app()->getLocale()) @endphp
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ $guesthouse->getDetailUrl(app()->getLocale()) }}">
                                @if($image_url = get_file_url($guesthouse->image_id, 'thumb'))
                                    <a href="{{ $guesthouse->getDetailUrl(app()->getLocale()) }}">
                                        {!! get_image_tag($guesthouse->image_id,'thumb',['class'=>'','alt'=>$guesthouse->title]) !!}
                                    </a>
                                @endif
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="{{ $guesthouse->getDetailUrl(app()->getLocale()) }}">
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
