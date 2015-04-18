<div class="form-group">
    <label for="<?php echo $field->Field; ?>" class="col-sm-2 control-label"><?php if(isset($labels[$field->Field])){ echo $labels[$field->Field]; }else { echo $field->Field; } ?></label>
    <div class="col-sm-10">
        <input type="{{ $types[$field->Type] }}" class="form-control" id="{{$field->Field}}" name="{{$field->Field}}" <?php if($field->Null=="NO") echo 'required';?> placeholder="{{$data[$field->Field]}}">
    </div>
</div>