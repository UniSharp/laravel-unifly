<?php
namespace Unisharp\Arca;

use Illuminate\Support\ServiceProvider;

class ArcaServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {

        $this->app->singleton('unisharp::make:us-controller', function ($app) {
            return new \Unisharp\Arca\Console\Commands\ControllerMakeCommand($app['files']);
        });

        $this->commands([
            'unisharp::make:us-controller',
        ]);
    }
}
