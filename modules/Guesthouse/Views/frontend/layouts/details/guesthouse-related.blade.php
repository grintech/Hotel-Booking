@if(count($guesthouse_related) > 0)
    <div class="bravo-list-hotel-related">
        <h2>{{__("You might also like")}}</h2>
        <div class="row">
            @foreach($guesthouse_related as $k=>$item)
                <div class="col-md-3">
                    @include('Guesthouse::frontend.layouts.search.loop-grid',['row'=>$item])
                </div>
            @endforeach
        </div>
    </div>
@endif