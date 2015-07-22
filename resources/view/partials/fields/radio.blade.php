<div class="form-group @if($errors->has($field) ) has-error @endif">
    <?php $i=0; ?>
    @foreach($data as $radio)
        <div class="radio">
            <label class="col-md-3 control-label">
                <input type="radio" name="{{$field}}" id="{{$field}}{{$i}}" value="{{$radio['value']}}" <?php if($required) echo 'required';?>  <?php if($radio['checked']) echo 'checked';?>>
                {{$radio['label']}}
            </label>
        </div>
        <?php $i++; ?>
    @endforeach
    <span class="help-block">{{$errors->first($field)}}</span>
</div>
