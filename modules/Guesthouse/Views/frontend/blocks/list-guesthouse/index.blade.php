<div class="container">
    <div class="bravo-list-hotel layout_{{$style_list}}">
        @if($title)
        <div class="title">
            {{$title}}
        </div>
        @endif
        @if($desc)
            <div class="sub-title">
                {{$desc}}
            </div>
        @endif
        <div class="list-item">
            @if($style_list === "normal")
                <div class="row">
                    @foreach($rows as $row)
                        <div class="col-lg-{{$col ?? 3}} col-md-6">
                            @include('Guesthouse::frontend.layouts.search.loop-grid')
                        </div>
                    @endforeach
                </div>
            @endif
            @if($style_list === "carousel")
                <div class="owl-carousel">
                    @foreach($rows as $row)
                        @include('Guesthouse::frontend.layouts.search.loop-grid')
                    @endforeach
                </div>
            @endif
        </div>
        <div class="text-right">
            <a href="{{ route('guesthouse.search') }}" title="All Guesthouses" class="btn btn-link p-0">More</a>
        </div>
    </div>
</div>
