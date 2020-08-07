<div class="sidebar-widget widget_bloglist">
    <div class="sidebar-title">
        <h4>{{ $item->title }}</h4>
    </div>
    <ul class="thumb-list">
        @php $list_tours = $model_hikes->with(['translations'])->orderBy('id','desc')->limit(3)->get() @endphp
        @if($list_tours)
            @foreach($list_tours as $tour)
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
                            <a href="{{ $tour->getDetailUrl(app()->getLocale()) }}">{{$translation->title}}</a>
                        </h5>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
