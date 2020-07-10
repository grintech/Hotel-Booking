<style type="text/css">
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }
</style>
<div class="panel">
    <div class="panel-title"><strong>{{__("GPX Locations")}}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Upload Gpx File</label>
                    <div class="">
                        <div class="form-group form-group-image">
                            <label for="file-upload" class="control-label custom-file-upload">
                                <i class="fa fa-cloud-upload"></i> {{ isset($translation->gpx_file)?str_replace('/uploads/tour_gpx_files/','',$translation->gpx_file):__("Upload GPX File")}}
                            </label>
                            <input id="file-upload" name="gpx_file" accept=".gpx" type="file"
                                   value="{{ isset($translation->gpx_file)?$translation->gpx_file:__('Upload GPX File')}}"
                                   style="display:none;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                @if(is_default_lang())
                    <div class="form-group">
                        <label class="control-label">{{__("Location")}}</label>
                        <div class="">
                            <select name="location_id" class="form-control">
                                <option value="">{{__("-- Please Select --")}}</option>
                                <?php
                                $traverse = function ($locations, $prefix = '') use (&$traverse, $row) {
                                    foreach ($locations as $location) {
                                        $selected = '';
                                        if ($row->location_id == $location->id)
                                            $selected = 'selected';
                                        printf("<option value='%s' %s>%s</option>", $location->id, $selected, $prefix . ' ' . $location->name);
                                        $traverse($location->children, $prefix . '-');
                                    }
                                };
                                $traverse($hike_location);
                                ?>
                            </select>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#file-upload').change(function () {
        var i = $(this).prev('label').clone();
        var file = $('#file-upload')[0].files[0].name;
        $(this).prev('label').text(file);
    });
</script>