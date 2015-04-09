<div class="form container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <form class="form-horizontal" method="{{$method}}" action="{{$action}}">
                @foreach($fields as $field)
                    <div class="form-group">
                        <label for="{{$field->Field}}" class="col-sm-2 control-label">{{ $label[$field->Field] }}</label>
                        <div class="col-sm-10">
                            <input type="{{ $type[$field->Type] }}" class="form-control" id="{{$field->Field}}" name="{{$field->Field}}" <?php if($field->Null=="NO") echo 'required=""';?> placeholder="{{ $data->{$field->Field} }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Save</button>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </div>
</div>
