@foreach ($attributes as $attribute)
    <div class="panel">
        <div class="panel-title"><strong>{{__('Attribute: :name',['name'=>$attribute->name])}}</strong></div>
        <div class="panel-body">
            <div class="terms-scrollable">
                @if($attribute->name == "Technique")
                    @foreach($attribute->terms as $term)
                        <label class="term-item">
                            <input @if(!empty($selected_terms) and $selected_terms->contains($term->id)) checked @endif type="checkbox" name="terms[]" value="{{$term->id}}" class="attri">
                            <span class="term-name">{{$term->name}}</span>
                        </label>
                    @endforeach
                @else
                    @foreach($attribute->terms as $term)
                        <label class="term-item">
                            <input @if(!empty($selected_terms) and $selected_terms->contains($term->id)) checked @endif type="checkbox" name="terms[]" value="{{$term->id}}">
                            <span class="term-name">{{$term->name}}</span>
                        </label>
                    @endforeach

                @endif
            </div>
        </div>
    </div>
@endforeach
<script type="text/javascript">
    $(document).ready(function(){
        $('input.attri').on('change', function() {
            $('input.attri').not(this).prop('checked', false);
        });
    })
</script>