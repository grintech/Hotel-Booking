<div class="bravo-list-tour layout_{{$style_list}}">
    <div class="container">
        @if($title)
            <div class="title" style="margin-top: 15px">
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

                    @if(count($rows) > 0 && $show_more)
                        @include('Hike::frontend.layouts.search.loop-gird', [
                            'row' => $rows[0],
                            'is_more_item' => true
                        ])
                    @endif
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
    </div>
</div>
