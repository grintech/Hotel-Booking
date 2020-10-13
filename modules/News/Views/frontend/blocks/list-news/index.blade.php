<div class="bravo-list-news">
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
            <div class="row">
                @foreach($rows as $row)
                    <div class="col-lg-4 col-md-6">
                        @include('News::frontend.blocks.list-news.loop')
                    </div>
                @endforeach
            </div>
        </div>
        <div class="text-right">
            <a href="{{ route('news.index') }}" title="All Articles" class="anim btn btn-primary m-0">
                Show More <span class="fa fa-arrow-right"></span>
            </a>
        </div>
    </div>
</div>
