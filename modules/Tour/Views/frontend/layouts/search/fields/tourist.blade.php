<div class="form-select-guests">
    <div class="form-group">
        <i class="field-icon icofont-users-alt-1"></i>
        <div class="form-content dropdown-toggle" data-toggle="dropdown">
            <div class="wrapper-more">
                <div class="render check-in-render">
                    <span class="multi" data-html=":count Tourists"></span>
                </div>
                <label> {{ $field['title'] ?? "" }} </label>
                @php
                    $tourists = request()->query('tourists',1);
                @endphp
                <div class="render">
                    <span class="adults tourist" ><span class="one @if($tourists >1) d-none @endif">{{__('Tourists')}}</span> <span class="@if($tourists <= 1) d-none @endif multi" data-html="{{__(':count Tourists')}}">{{__(':count Tourists',['count'=>request()->query('tourists',1)])}}</span></span>
                </div>
            </div>
        </div>
        {{--id is being used to switch in js controller script--}}
        <div class="dropdown-menu select-guests-dropdown">
            <div class="dropdown-item-row">
                <div class="form-group w-100">
                    <input min="1" step="1" type="number" value="{{ $tourists }}" class="form-control" name="tourists" autocomplete="off" placeholder="{{ __('Number of Tourists') }}">
                </div>
            </div>
        </div>
    </div>
</div>
