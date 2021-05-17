<div class="sidebar-widget widget_bloglist">
    <div class="sidebar-title">
        <h2>{{ $item->title }}</h2>
    </div>
    <ul class="thumb-list">
        @php $list_blog = $model_news->with(['getCategory','translations'])->orderBy('id','desc')->limit(3)->get() @endphp
        @if($list_blog)
            @foreach($list_blog as $blog)
                @php $translation = $blog->translateOrOrigin(app()->getLocale()) @endphp
                <li>
                    @if($image_url = get_file_url($blog->image_id, 'thumb'))
                        <div class="thumb">
                            <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}">
                                {!! get_image_tag($blog->image_id,'thumb',['class'=>'','alt'=>$blog->title]) !!}
                            </a>
                        </div>
                    @endif
                    <div class="content">
                        <h3 class="thumb-list-item-title">
                            <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}">{!! clean($translation->title) !!}</a>
                        </h3>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
