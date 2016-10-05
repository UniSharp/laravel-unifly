<?php
namespace Unisharp\Unifly;

use Illuminate\Support\ServiceProvider;
use Unisharp\Unifly\Console\Commands\TranslatableMigrationCreator;

class UniflyServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {

        $this->app->singleton('unisharp::make:us-controller', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\ControllerMakeCommand($app['files']);
        });

        $this->app->singleton('unisharp::make:us-repository', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\RepositoryMakeCommand($app['files']);
        });

        $this->app->singleton('unisharp::make:us-presenter', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\PresenterMakeCommand($app['files']);
        });

        $this->app->singleton('unisharp::make:us-model', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\ModelMakeCommand($app['files']);
        });

        $this->app->singleton('unisharp::make:us-view', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\ViewMakeCommand($app['files']);
        });

        $this->app->singleton('unisharp::make:us-trans-migration', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\TranslatableMigrationMakeCommand(
                new TranslatableMigrationCreator($app['files']),
                $app['composer']
            );
        });

        $this->app->singleton('unisharp::make:us-model', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\ModelMakeCommand($app['files']);
        });

        $this->app->singleton('unisharp::make:us-test', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\TestMakeCommand($app['files']);
        });

        $this->app->singleton('unisharp::make:entity', function ($app) {
            return new \Unisharp\Unifly\Console\Commands\MakeEntity($app['files']);
        });

        $this->commands([
            'unisharp::make:us-controller',
            'unisharp::make:us-repository',
            'unisharp::make:us-presenter',
            'unisharp::make:us-view',
            'unisharp::make:us-model',
            'unisharp::make:us-trans-migration',
            'unisharp::make:us-test',
            'unisharp::make:entity',
        ]);
    }
}
