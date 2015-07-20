<div class="form-group">
    <?php $i=0; ?>
    @foreach($data as $radio)
        <div class="radio-inline">
            <label>
                <input type="radio" name="{{$field}}" id="{{$field}}{{$i}}" value="{{$radio['value']}}" <?php if($required) echo 'required';?>  <?php if($radio['checked']) echo 'checked';?>>
                {{$radio['label']}}
            </label>
        </div>
        <?php $i++; ?>
    @endforeach
</div>