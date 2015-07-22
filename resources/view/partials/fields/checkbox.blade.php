@if(is_null($trans))
    <div class="form-group @if($errors->has($field) ) has-error @endif">
        <div class="checkbox">
            <label class="col-md-3 control-label">
                <input type="checkbox" id="{{$field}}" name="{{$field}}" <?php if($required) echo 'required';?> <?php if(isset($fieldData) && $fieldData == 1){ echo "checked"; }?>>
                <?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?>
            </label>
            <span class="help-block">{{$errors->first($field)}}</span>
        </div>
    </div>
@else
    <div class="form-group @if($errors->has($field) ) has-error @endif">
        <div class="checkbox">
            <label class="col-md-3 control-label">
                <input type="checkbox" id="{{$field}}" name="{{$field}}" <?php if($required) echo 'required';?> <?php if(isset($fieldData) && $fieldData == 1){ echo "checked"; }?>>
                {{ trans($trans.'model.general.'.$field) }}
            </label>
            <span class="help-block">{{$errors->first($field)}}</span>
        </div>
    </div>
@endif