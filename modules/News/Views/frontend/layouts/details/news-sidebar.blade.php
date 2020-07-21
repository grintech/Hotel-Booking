<aside class="sidebar-right" style="position: sticky; position: -webkit-sticky; top: 10px; z-index: 10;">
    @php
        $list_sidebars = setting_item_with_lang("news_sidebar");
    @endphp
    @if($list_sidebars)
        @php
            $list_sidebars = json_decode($list_sidebars);
        @endphp
        @foreach($list_sidebars as $item)
            @include('News::frontend.layouts.sidebars.'.$item->type)
        @endforeach
    @endif
</aside>