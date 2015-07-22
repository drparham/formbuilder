@if(is_null($trans))
    <div class="form-group @if($errors->has($field) ) has-error @endif">
        <label for="<?php echo $field; ?>" class="col-md-3 control-label"><?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?></label>
        <div class="col-md-9">
            <input type="date" class="form-control" id="{{$field}}" name="{{$field}}" <?php if($required=="NO") echo 'required';?> placeholder="<?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?>" value="<?php if(isset($fieldData)){ echo $fieldData; }?>">
            <span class="help-block">{{$errors->first($field)}}</span>
        </div>
    </div>
@else
    <div class="form-group @if($errors->has($field) ) has-error @endif">
        <label for="<?php echo $field; ?>" class="col-md-3 control-label">{{ trans($trans.'model.general.'.$field) }}</label>
        <div class="col-md-9">
            <input type="date" class="form-control" id="{{$field}}" name="{{$field}}" <?php if($required=="NO") echo 'required';?> placeholder="{{ trans($trans.'model.general.'.$field) }}" value="{{ Input::old($field, $fieldData) }}">
            <span class="help-block">{{$errors->first($field)}}</span>
        </div>
    </div>
@endif