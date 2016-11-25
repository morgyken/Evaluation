<?php

namespace Ignite\Evaluation\Providers;

use Ignite\Evaluation\Console\AutoCheckout;
use Ignite\Evaluation\Library\BikaFunctions;
use Ignite\Evaluation\Library\EvaluationFunctions;
use Ignite\Evaluation\Repositories\BikaRepository;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Illuminate\Support\ServiceProvider;

class EvaluationServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerBindings();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    /**
     * Register my bindings
     */
    public function registerBindings()
    {
        $this->app->bind(EvaluationRepository::class, EvaluationFunctions::class);
        // $this->app->bind(EvaluationFinanceRepository::class,EvaluationFinanceFunctions::class);
        $this->app->bind(BikaRepository::class, BikaFunctions::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('evaluation.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'evaluation'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/evaluation');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/evaluation';
        }, \Config::get('view.paths')), [$sourcePath]), 'evaluation');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/evaluation');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'evaluation');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'evaluation');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerCommands()
    {
        $this->commands([AutoCheckout::class]);
    }

}
