<div class="sidebar-widget widget_bloglist"  style="position: sticky; position: -webkit-sticky; top: 100px; background-color: white;">
    <div class="sidebar-title">
        <h4>{{ $item->title }}</h4>
    </div>
    <ul class="thumb-list">
        @php $list_guesthouses = $model_guesthouses->with(['translations'])->orderBy('id','desc')->limit(3)->get() @endphp
        @if($list_guesthouses)
            @foreach($list_guesthouses as $guesthouse)
                @php $translation = $guesthouse->translateOrOrigin(app()->getLocale()) @endphp
                <li>
                    @if($image_url = get_file_url($guesthouse->image_id, 'thumb'))
                        <div class="thumb">
                            <a href="{{ $guesthouse->getDetailUrl(app()->getLocale()) }}">
                                {!! get_image_tag($guesthouse->image_id,'thumb',['class'=>'','alt'=>$guesthouse->title]) !!}
                            </a>
                        </div>
                    @endif
                    <div class="content">
                        <h5 class="thumb-list-item-title">
                            <a href="{{ $guesthouse->getDetailUrl(app()->getLocale()) }}">{{$translation->title}}</a>
                        </h5>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
