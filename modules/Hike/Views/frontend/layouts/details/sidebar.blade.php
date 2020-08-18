@php
    $list_sidebars = setting_item_with_lang("hike_sidebar");
@endphp
@if($list_sidebars)
    @php
        $list_sidebars = json_decode($list_sidebars);
    @endphp
    @foreach($list_sidebars as $item)
        @include('Hike::frontend.layouts.details.sidebar.'.$item->type)
    @endforeach
@endif