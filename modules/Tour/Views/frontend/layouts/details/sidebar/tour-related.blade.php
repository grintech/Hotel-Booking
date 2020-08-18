@if(count($tour_related) > 0)
    <div class="sidebar-widget widget_bloglist" style="margin-top: 30px">
        <div class="sidebar-title">
            <h4>{{ $item->title }}</h4>
        </div>
        <ul class="thumb-list">
            @foreach($tour_related as $tour)
                @php $translation = $tour->translateOrOrigin(app()->getLocale()) @endphp
                <li>
                    @if($image_url = get_file_url($tour->image_id, 'thumb'))
                        <div class="thumb">
                            <a href="{{ $tour->getDetailUrl(app()->getLocale()) }}">
                                {!! get_image_tag($tour->image_id,'thumb',['class'=>'','alt'=>$tour->title]) !!}
                            </a>
                        </div>
                    @endif
                    <div class="content">
                        <h5 class="thumb-list-item-title">
                            <a href="{{ $tour->getDetailUrl(app()->getLocale()) }}">{{$tour->title}}</a>
                        </h5>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif