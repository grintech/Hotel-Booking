@php
    $terms_ids = $row->hike_term->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $attribute )
        @php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
        @if($translate_attribute->name == "Techniques" or $translate_attribute->name == "Technique")
            <div class="col-md-5th-1 col-md-offset-0 col-sm-offset-2">
                <div class="item">
                    <div class="icon">
                        <img class="sand-clock-manage" data-toggle="tooltip" data-placement="top" src="{{asset('icon/hill.svg')}}" alt="sand-clock">
                        <!-- <i class="icofont-travelling"></i> -->
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Technique")}}</h4>
                        <p class="value">
                        @php $terms = $attribute['child'] @endphp
                        @foreach($terms as $term )
                            @php $translate_term = $term->translateOrOrigin(app()->getLocale()) @endphp
                            <p class="value">{{$translate_term->name}}                    </p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    @endforeach
@endif