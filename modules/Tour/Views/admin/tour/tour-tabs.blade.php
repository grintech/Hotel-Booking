<div class="panel">
    <div class="panel-title"><strong>{{__("Hike Tabs")}}</strong></div>
    <div class="panel-body">

        <div class="form-group">
            <label class="control-label">{{__("The Guided Tour")}}</label>
            <div class="">
                <textarea name="the_tour" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->the_tour}}</textarea>
            </div>
        </div>
<!--         <div class="form-group">
            <label class="control-label">{{__("Details")}}</label>
            <div class="">
                <textarea name="details" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->details}}</textarea>
            </div>
        </div> -->
        <div class="form-group">
            <label class="control-label">{{__("Directions")}}</label>
            <div class="">
                <textarea name="Turn_by_turn_locations" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->Turn_by_turn_locations}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{__("Getting There")}}</label>
            <div class="">
                <textarea name="getting_there" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->getting_there}}</textarea>
            </div>
        </div>
<!--         <div class="form-group">
            <label class="control-label">{{__("Literature")}}</label>
            <div class="">
                <textarea name="literature" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->literature}}</textarea>
            </div>
        </div> -->
<!--         <div class="form-group">
            <label class="control-label">{{__("Current information")}}</label>
            <div class="">
                <textarea name="current_information" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->current_information}}</textarea>
            </div>
        </div> -->


    </div>
<div class="panel">
    <div class="panel-title"><strong>{{__("Details")}}</strong></div>
    <div class="panel-body">

        <div class="form-group">
            <label>{{__("Highest Point")}}</label>
            <input type="text" value="{{$translation->highest_point}}" placeholder="{{__("Highest Point")}}" name="highest_point" class="form-control">
        </div>

        <div class="form-group">
            <label>{{__("Lowest Point")}}</label>
            <input type="text" value="{{$translation->lowest_point}}" placeholder="{{__("Lowest Point")}}" name="lowest_point" class="form-control">
        </div>

        <div class="form-group">
            <label>{{__("Experience")}}</label>
            <input type="number" value="{{$translation->experience}}" placeholder="{{__("Experience")}}" name="experience" class="form-control">
        </div>

        <div class="form-group">
            <label>{{__("Landscape")}}</label>
            <input type="number" value="{{$translation->landscape}}" placeholder="{{__("Landscape")}}" name="landscape" class="form-control">
        </div>

        <div class="form-group">
            <label>{{__("Best Time of the Year to do the Hike")}}</label>
            <input type="text" value="{{$translation->best_time}}" placeholder="{{__("Best Time of the Year to do the Hike")}}" name="best_time" class="form-control">
        </div>

    <div class="form-group">
            <label>{{__("Safety Information")}}</label>
            <div class="">
                <textarea name="safety_information" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->safety_information}}</textarea>
            </div>
        </div>

    </div>
</div>
</div>

