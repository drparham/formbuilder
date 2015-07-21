<div class="form container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <form class="form-horizontal" method="<?php echo $method; ?>" action="<?php echo $action ?>">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                @foreach($form as $field)
                    {!! $field !!}
                @endforeach
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>