<div class="form container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <form class="form-horizontal" method="<?php echo $method; ?>" action="<?php echo $action ?>">
                @foreach($fields as $field)
                    <div class="form-group">
                        <label for="<?php echo $field->Field; ?>" class="col-sm-2 control-label"><?php if(isset($labels[$field->Field])){ echo $labels[$field->Field]; }else { echo $field->Field; } ?></label>
                        <div class="col-sm-10">
                            <input type="{{ $types[$field->Type] }}" class="form-control" id="{{$field->Field}}" name="{{$field->Field}}" <?php if($field->Null=="NO") echo 'required';?> placeholder="<?php if(isset($labels[$field->Field])){ echo $labels[$field->Field]; }else { echo $field->Field; } ?>">
                        </div>
                    </div>
                @endforeach
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>