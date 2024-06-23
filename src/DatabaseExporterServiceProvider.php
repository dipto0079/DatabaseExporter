<?php

namespace dipto0079\DatabaseExporter;

use Illuminate\Support\ServiceProvider;
use dipto0079\DatabaseExporter\Console\Commands\ExportDatabase;

class DatabaseExporterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register the command
        $this->commands([
            ExportDatabase::class,
        ]);

        // Merge package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/scheduler.php', 'scheduler');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/scheduler.php' => config_path('scheduler.php'),
        ]);
    }
}
