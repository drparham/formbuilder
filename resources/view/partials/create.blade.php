@if(!is_null($params))
    <form class="form-horizontal" method="<?php echo $method; ?>" action="{{ route($action, $params) }}">
@else
    <form class="form-horizontal" method="<?php echo $method; ?>" action="{{ route($action) }}">
@endif
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <fieldset>
        @foreach($form as $field)
            {!! $field !!}
        @endforeach
        <div class="form-group">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </fieldset>
</form>
