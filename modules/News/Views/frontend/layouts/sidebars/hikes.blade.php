<div class="sidebar-widget widget_bloglist">
    <div class="sidebar-title">
        <h4>{{ $item->title }}</h4>
    </div>
    <ul class="thumb-list">
        @php $list_hike = $model_hikes->with(['translations'])->orderBy('id','desc')->limit(3)->get() @endphp
        @if($list_hike)
            @foreach($list_hike as $hike)
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
                            <a href="{{ $hike->getDetailUrl(app()->getLocale()) }}">{{$translation->title}}</a>
                        </h5>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
