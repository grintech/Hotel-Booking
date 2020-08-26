@php
    $terms_ids = $row->terms->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $key => $attribute )
        @php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
        @if(empty($attribute['parent']['hide_in_single']))
            @php $terms = $attribute['child'] @endphp
            @if(count($terms) > 0)
                <span style="margin-right: 8px; padding: 5px 10px; background-color: rgba(81,145,250,.1); border-radius: 20px;">
                    <i class="{{ $term[0]->icon ?? "icofont-check-circled icon-default" }}"></i>
                    <b>{{ $translate_attribute->name }}</b>: {{ $terms[0]->translateOrOrigin(app()->getLocale())->name }}
                </span>
            @endif
        @endif
    @endforeach
@endif
