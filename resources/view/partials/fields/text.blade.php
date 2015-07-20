<div class="form-group">
    <label for="<?php echo $field; ?>" class="col-sm-2 control-label"><?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?></label>
    <div class="col-sm-10">
        <textarea class="form-control" id="{{$field}}" name="{{$field}}"><?php if(isset($fieldData)){ echo $fieldData; }?></textarea>
    </div>
</div>