@if(is_null($trans))
    <div class="form-group @if($errors->has($field) ) has-error @endif">
        <label for="<?php echo $field; ?>" class="col-md-3 control-label"><?php if(isset($labels[$field])){ echo $labels[$field]; }else { echo $field; } ?></label>
        <div class="col-md-9">
            <select id="{{ $field }}" name="{{ $field }}[]" <?php if($required=="NO") echo 'required';?> class="form-control select" multiple>
                @if(isset($fieldData))
                    <?php $selected = 0; ?>
                @endif
                @foreach($data as $option)
                    @if(isset($fieldData))

                        @foreach($fieldData as $relation)
                            @if($option->id == $relation->id)
                                <?php $selected = $option->id; ?>
                            @endif
                        @endforeach
                        @if( (int)$option->id == $selected )
                            <option value="{{ $option->id }}" selected="">{{ $option->{$name} }}</option>
                        @else
                            <option value="{{ $option->id }}">{{ $option->{$name} }}</option>
                        @endif
                    @else
                        <option value="{{ $option->id }}">{{ $option->{$name} }}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block">{{{$errors->first($field)}}}</span>
        </div>
    </div>
@else
    <div class="form-group @if($errors->has($field) ) has-error @endif">
        <label for="<?php echo $field; ?>" class="col-md-3 control-label">{{ trans($trans.'model.general.'.$field) }}</label>
        <div class="col-md-9">
            <select id="{{ $field }}" name="{{ $field }}[]" <?php if($required=="NO") echo 'required';?> class="form-control select" multiple>
                @if(isset($fieldData))
                    <?php $selected = 0; ?>
                @endif
                @foreach($data as $option)
                    @if(isset($fieldData))

                        @foreach($fieldData as $relation)
                            @if($option->id == $relation->id)
                                <?php $selected = $option->id; ?>
                            @endif
                        @endforeach
                        @if( (int)$option->id == $selected )
                            <option value="{{ $option->id }}" selected="">{{ $option->{$name} }}</option>
                        @else
                            <option value="{{ $option->id }}">{{ $option->{$name} }}</option>
                        @endif
                    @else
                        <option value="{{ $option->id }}">{{ $option->{$name} }}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block">{{$errors->first($field)}}</span>
        </div>
    </div>
@endif