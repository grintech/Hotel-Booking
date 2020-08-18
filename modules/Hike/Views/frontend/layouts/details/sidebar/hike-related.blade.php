@if(count($hike_related) > 0)
    <div class="sidebar-widget widget_bloglist" style="margin-top: 30px">
        <div class="sidebar-title">
            <h4>{{ $item->title }}</h4>
        </div>
        <ul class="thumb-list">
            @foreach($hike_related as $hike)
                @php $translation = $hike->translateOrOrigin(app()->getLocale()) @endphp
                <li>
                    @if($image_url = get_file_url($hike->image_id, 'thumb'))
                        <div class="thumb">
                            <a href="{{ $hike->getDetailUrl(app()->getLocale()) }}">
                                {!! get_image_tag($hike->image_id,'thumb',['class'=>'','alt'=>$hike->title]) !!}
                            </a>
                        </div>
                    @endif
                    <div class="content">
                        <h5 class="thumb-list-item-title">
                            <a href="{{ $hike->getDetailUrl(app()->getLocale()) }}">{{$hike->title}}</a>
                        </h5>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif