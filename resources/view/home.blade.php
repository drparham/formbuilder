@extends('orchestra/foundation::layouts.page')

@section('content')
    @include('pta/formbuilder::widgets.header')

    <div class="row">
        <div class="jumbotron">
            <div class="page-header">
                <h2>FormBuilder for Orchestra Platform</h2>
            </div>
            <div class="section">
                {!! FormBuilder::buildForm('App\User', 'POST', '/', 'update',1) !!}
            </div>
        </div>
    </div>
@stop
