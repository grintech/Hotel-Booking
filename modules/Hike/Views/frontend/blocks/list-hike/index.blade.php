<div class="bravo-list-tour {{$style_list}}">
    <div class="container">
        @if($title)
            <div class="title">
                {{$title}}
                @if(!empty($desc))
                    <div class="sub-title">
                        {{$desc}}
                    </div>
                @endif
            </div>
        @endif
        <div class="list-item">
            @if($style_list === "normal")
                <div class="row">
                    @foreach($rows as $row)
                        <div class="col-lg-{{$col ?? 3}} col-md-6">
                            @include('Hike::frontend.layouts.search.loop-gird')
                        </div>
                    @endforeach
                </div>
            @endif
            @if($style_list === "carousel")
                <div class="owl-carousel">
                    @foreach($rows as $row)
                        @include('Hike::frontend.layouts.search.loop-gird')
                    @endforeach
                </div>
            @endif
            @if($style_list === "box_shadow")
                <div class="row row-eq-height">
                    @foreach($rows as $row)
                        <div class="col-lg-{{$col ?? 4}} col-md-6 col-item">
                            @include('Hike::frontend.blocks.list-hike.loop-box-shadow')
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="text-right">
            <a href="{{ route('hike.search') }}" title="All Hikes" class="btn btn-link p-0">More</a>
        </div>
    </div>
</div>
