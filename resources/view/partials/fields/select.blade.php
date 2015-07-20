<div class="form-group">
    <label for="<?php echo $field; ?>" class="col-sm-2 control-label"><?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?></label>
    <div class="col-sm-10">
        <select id="{{ $field }}" name="{{ $field }}" <?php if($required=="NO") echo 'required';?> >
            @foreach($data as $option)
            <option id="{{ $option->id }}">{{ $option->name }}</option>
            @endforeach
        </select>
    </div>
</div>