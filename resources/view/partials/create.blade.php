<div class="form container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <form class="form-horizontal" method="<?php echo $method; ?>" action="<?php echo $action ?>">
                @foreach($form as $field)
                    {!! $field !!}
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