<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" id="{{$field}}" name="{{$field}}" <?php if($required) echo 'required';?> >
            <?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?>
        </label>
    </div>
</div>