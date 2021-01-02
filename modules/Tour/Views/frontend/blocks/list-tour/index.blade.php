<div class="bravo-list-tour mt-4 {{$style_list}}">
    <div class="container">
        @if($title)
            <div class="title" style="font-weight: 500;">
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
                            @include('Tour::frontend.layouts.search.loop-gird')
                        </div>
                    @endforeach

                    @if(count($rows) > 0 && $show_more)
                        <div class="col-lg-{{$col ?? 3}} col-md-6">
                            @include('Tour::frontend.layouts.search.loop-gird', [
                                'row' => $rows[0],
                                'is_more_item' => true
                            ])
                        </div>
                    @endif
                </div>
            @endif
            @if($style_list === "carousel")
                <div class="owl-carousel">
                    @foreach($rows as $row)
                        @include('Tour::frontend.layouts.search.loop-gird')
                    @endforeach

                    @if(count($rows) > 0 && $show_more)
                        @include('Tour::frontend.layouts.search.loop-gird', [
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
                            @include('Tour::frontend.blocks.list-tour.loop-box-shadow')
                        </div>
                    @endforeach

                    @if(count($rows) > 0 && $show_more)
                        <div class="col-lg-{{$col ?? 4}} col-md-6 col-item">
                            @include('Tour::frontend.blocks.list-tour.loop-box-shadow', [
                                'row' => $rows[0],
                                'is_more_item' => true
                            ])
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
