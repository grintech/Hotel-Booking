<div class="col-lg-{{$col ?? 3}} col-md-6">
    <div class="item-loop {{$wrap_class ?? ''}}" style="min-height: 320px; min-width: 250px; position: relative">
        @if($background_image)
            <div style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; opacity: .3; background-image: url('https://pix10.agoda.net/hotelImages/522/522433/522433_16080414390045216028.jpg?s=1024x768'); background-size: cover;">
            </div>
        @endif

        <div  style="display: flex; flex-direction: column; justify-content: center; align-items: center; position: absolute; top: 0; bottom: 0; left: 0; right: 0;">
            <a href="{{ $launcher_url }}" class="btn btn-primary">{{ __('Show more') }}</a>
            <p class="item-title text-center">{{ $description }}</p>
        </div>
    </div>
</div>
