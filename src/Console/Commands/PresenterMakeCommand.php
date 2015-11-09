<?php

namespace Unisharp\Unifly\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class PresenterMakeCommand extends UsGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:us-presenter {name} {entity_name} {--for=backend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    protected $type = 'Presenter';


    public function getStub()
    {
        if ($this->for == 'api') {
            return __DIR__ . '/stubs/Presenter/ApiPresenter.stub';
        }

        return __DIR__ . '/stubs/Presenter/Presenter.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Presenter';
    }

    protected function getPath($name)
    {
        if ($this->for == 'api') {
            // \App\Presenter\SomePresenter => \App\Presenter\Api\SomePresenter
            $name = str_replace($this->laravel->getNamespace(), '', $name);
            $name = explode('\\', $name);
            array_splice($name, 1, null, 'Api');
            $name = implode('\\', $name);
            return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
        }

        return parent::getPath($name);
    }
}
