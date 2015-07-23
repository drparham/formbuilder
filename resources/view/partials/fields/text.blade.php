@if(is_null($trans))
<div class="form-group @if($errors->has($field) ) has-error @endif">
    <label for="<?php echo $field; ?>" class="col-md-3 control-label"><?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?></label>
    <div class="col-md-9">
        <textarea class="form-control" id="{{$field}}" name="{{$field}}"><?php if(isset($fieldData)){ echo $fieldData; }?></textarea>
        <span class="help-block">{{{$errors->first($field)}}}</span>
    </div>
</div>
@else
    <div class="form-group @if($errors->has($field) ) has-error @endif">
        <label for="<?php echo $field; ?>" class="col-md-3 control-label">{{ trans($trans.'model.general.'.$field) }}</label>
        <div class="col-md-9">
            <textarea class="form-control" id="{{$field}}" name="{{$field}}"><?php if(isset($fieldData)){ echo $fieldData; }?></textarea>
            <span class="help-block">{{{$errors->first($field)}}}</span>
        </div>
    </div>
@endif

