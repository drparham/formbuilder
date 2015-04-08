<?php namespace Abh\Formbuilder\Providers;

use Abh\Formbuilder\Lib\FormBuilder;
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
        $this->bindIf('abh.formbuilder.lib.formbuilder', 'Abh\Formbuilder\Lib\FormBuilder');

        $this->app['FormBuilder'] = $this->app->share(function($app)
        {
            return new FormBuilder();
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('FormBuilder', 'Abh\Formbuilder\Facades\FormBuilder');

    }

}