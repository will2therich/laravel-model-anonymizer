<?php
namespace will2therich\LaravelModelAnonymizer;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use will2therich\LaravelModelAnonymizer\Commands\AnonymizeCommand;
use will2therich\LaravelModelAnonymizer\Commands\InstallCommand;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInstallCommand();

        $this->registerAnonymizeCommand();
    }

    /**
     * Register db:mode-anonymize command.
     *
     * @return void
     */
    protected function registerAnonymizeCommand()
    {
        $this->app->singleton('command.db.model-anonymize', function ($app) {
            return new AnonymizeCommand();
        });

        $this->commands('command.db.model-anonymize');
    }

    /**
     * Register anonymization:install command.
     *
     * @return void
     */
    protected function registerInstallCommand()
    {
        $this->app->singleton('command.model-anonymizer.install', function ($app) {
            return new InstallCommand($app['files'], $app['composer']);
        });

        $this->commands('command.model-anonymizer.install');
    }


}