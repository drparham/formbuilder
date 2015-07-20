<div class="form-group">
    <div class="checkbox-inline">
        <label>
            <input type="checkbox" id="{{$field}}" name="{{$field}}" <?php if($required) echo 'required';?> <?php if(isset($fieldData) && $fieldData == 1){ echo "checked"; }?>>
            <?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?>
        </label>
    </div>
</div>