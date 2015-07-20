<div class="form-group">
    <label for="<?php echo $field; ?>" class="col-sm-2 control-label"><?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?></label>
    <div class="col-sm-10">
        <select id="{{ $field }}" name="{{ $field }}" <?php if($required=="NO") echo 'required';?> >
            @foreach($data as $option)
                @if(isset($fieldData))
                    @if($option->id == $fieldData)
                        <option value="{{ $option->id }}" selected="selected">{{ $option->name }}</option>
                    @else
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endif
                @else
                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>