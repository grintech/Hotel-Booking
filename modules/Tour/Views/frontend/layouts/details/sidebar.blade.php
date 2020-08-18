@php
    $list_sidebars = setting_item_with_lang("tour_sidebar");
@endphp
@if($list_sidebars)
    @php
        $list_sidebars = json_decode($list_sidebars);
    @endphp
    @foreach($list_sidebars as $item)
        @include('Tour::frontend.layouts.details.sidebar.'.$item->type)
    @endforeach
@endif