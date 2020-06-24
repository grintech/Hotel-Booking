<form action="{{url(app_get_locale(false,false,'/').config('hike.hike_route_prefix'))}}" class="form bravo_form" method="get">
    <div class="g-field-search">
        <div class="row">
            @php $hike_search_fields = setting_item_array('hike_search_fields');
            $hike_search_fields = array_values(\Illuminate\Support\Arr::sort($hike_search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
            @endphp
            @if(!empty($hike_search_fields))
                @foreach($hike_search_fields as $field)
                    <div class="col-md-{{ $field['size'] ?? "6" }} border-right">
                        @switch($field['field'])
                            @case ('service_name')
                                @include('Hike::frontend.layouts.search.fields.service_name')
                            @break
                            @case ('location')
                                @include('Hike::frontend.layouts.search.fields.location')
                            @break
                            @case ('date')
                                @include('Hike::frontend.layouts.search.fields.date')
                            @break
                        @endswitch
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="g-button-submit">
        <button class="btn btn-primary btn-search" type="submit">{{__("Search")}}</button>
    </div>
</form>