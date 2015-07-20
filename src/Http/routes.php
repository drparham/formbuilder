<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;


Route::group([
    'prefix'    => 'formbuilder',
    'namespace' => 'Pta\Formbuilder\Controllers\Frontend',
], function()
{
    Route::get('/' , ['as' => 'formbuilder.all', 'uses' => 'FormBuilderController@index']);

});
