<div class="form-group">
    <label for="<?php echo $field; ?>" class="col-sm-2 control-label"><?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?></label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="{{$field}}" name="{{$field}}" <?php if($required=="NO") echo 'required';?> placeholder="{{$data[$field]}}">
    </div>
</div>