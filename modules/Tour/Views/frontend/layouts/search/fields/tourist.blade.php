<div class="form-select-guests" id="participants">
    <div class="form-group">
        <i class="field-icon icofont-users-alt-1"></i>
        <div class="form-content dropdown-toggle" data-toggle="dropdown">
            <div class="wrapper-more">
                <label> {{ $field['title'] ?? "" }} </label>
                @php
                    $tourists = request()->query('tourists',1);
                @endphp
                <div class="render">
                    <span class="adults" ><span class="one @if($tourists >1) d-none @endif">{{__('1 Participant')}}</span> <span class="@if($tourists <= 1) d-none @endif multi" data-html="{{__(':count Participants')}}">{{__(':count Participants',['count'=>request()->query('tourists',1)])}}</span></span>
                </div>
            </div>
        </div>
        <div class="dropdown-menu select-guests-dropdown" >
            <div class="dropdown-item-row">
                <div class="label">{{__('Participants')}}</div>
                <div class="val">
                    <span class="btn-minus" data-input="tourists"><i class="icon ion-md-remove"></i></span>
                    <span class="count-display"><input step="1" type="number" name="tourists" value="{{request()->query('adults',1)}}" min="1"></span>
                    <span class="btn-add" data-input="tourists"><i class="icon ion-ios-add"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

