@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @parent

@stop

{{-- Meta description --}}
@section('meta-description')

@stop

{{-- Queue styles/scripts --}}
{{ Asset::queue('welcome', 'platform/less/welcome.less', 'style') }}

{{-- Page Header --}}
@section('header')

    <!-- Full Width Image Header -->
    <div class="caption">

        <div class="container">

            <h1>
                Heading H1
            </h1>

            <h2>Headline</h2>

            <p>{{FormBuilder::buildForm('Abh\Formbuilder\Models\User', 'POST', '/', 'create')}}</p>

        </div>

    </div>

@stop

{{-- Page content --}}
@section('page')

    <!-- Featurette -->
    <div class="featurette featurette--left">
        <div class="featurette__caption">
            @content('featurette-packages')
        </div>
        <div class="featurette__image">
            <img src="{{ Asset::getUrl('platform/img/featurette-packages.svg') }}" alt="Package Based Architecture">
        </div>
    </div>

    <hr class="featurette-divider">

    <!-- Featurette -->
    <div class="featurette featurette--right">
        <div class="featurette__image">
            <img src="{{ Asset::getUrl('platform/img/featurette-extensions.svg') }}" alt="Extension Driven Design">
        </div>
        <div class="featurette__caption">
            @content('featurette-extensions')
        </div>
    </div>

    <hr class="featurette-divider">

    <!-- Featurette -->
    <div class="featurette featurette--left">
        <div class="featurette__caption">
            @content('featurette-themes')
        </div>
        <div class="featurette__image">
            <img src="{{ Asset::getUrl('platform/img/featurette-themes.svg') }}" alt="Powerful Theme System">
        </div>
    </div>

    <hr class="featurette-divider">

@stop
