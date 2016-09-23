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

        $this->registerConfig();
//        $this->registerMigrations();
//        $this->registerTranslations();
        $this->registerViews();
//        $this->bootExtensionRouting();

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

        $loader = AliasLoader::getInstance();
        $loader->alias('FormBuilder', 'Pta\Formbuilder\Facades\FormBuilder');

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('formbuilder.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', 'formbuilder'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/vendor/pta/formbuilder');

        $sourcePath = __DIR__.'/../../resources/view';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom([$viewPath, $sourcePath], 'pta/formbuilder');

    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/vendor/pta/lms');
        $sourcePath = __DIR__ .'/../resources/lang';

        $this->publishes([
            $sourcePath => $langPath
        ], 'translations');

        $this->loadTranslationsFrom([$langPath, $sourcePath], 'pta/formbuilder');

    }


    public function registerMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    public function registerSeeds()
    {
        $this->publishes([
            __DIR__.'/../database/seeds/' => database_path('seeds')
        ], 'seeds');
    }

    /**
     * Boot extension routing.
     *
     * @param  string  $path
     *
     * @return void
     */
    protected function bootExtensionRouting()
    {
        $path = realpath(__DIR__.'/../../');
        require_once "{$path}/src/Http/routes.php";
    }

}