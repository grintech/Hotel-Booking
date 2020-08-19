@php
    $guesthouse_related = $guesthouse_related ? $guesthouse_related->get(): [];
@endphp
@if(count($guesthouse_related) > 0)
    <div class="sidebar-widget widget_bloglist" style="margin-top: 30px">
        <div class="sidebar-title">
            <h4>{{ $item->title }}</h4>
        </div>
        <ul class="thumb-list">
            @foreach($guesthouse_related as $guesthouse)
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
                            <a href="{{ $guesthouse->getDetailUrl(app()->getLocale()) }}">{{$guesthouse->title}}</a>
                        </h5>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif