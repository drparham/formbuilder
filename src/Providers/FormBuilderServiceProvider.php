<?php namespace Pta\Formbuilder\Providers;

use Pta\Formbuilder\Lib\FormBuilder;
use Cartalyst\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class FormBuilderServiceProvider extends ServiceProvider
{


    /**
     * {@inheritDoc}
     */
    public function boot()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        // Register the Form Builder
        $this->bindIf('pta.formbuilder.lib.formbuilder', 'Pta\Formbuilder\Lib\FormBuilder');

        $this->app['FormBuilder'] = $this->app->share(function($app)
        {
            return new FormBuilder();
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('FormBuilder', 'Pta\Formbuilder\Facades\FormBuilder');

    }

}