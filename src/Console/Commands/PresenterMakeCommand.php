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
        $ns = $rootNamespace . '\Presenter';
        $specifyNamespace = ['api'];

        if (in_array($this->for, $specifyNamespace)) {
            $ns .= '\\' . Str::studly($this->for);
        }

        return $ns;
    }

    protected function getPath($name)
    {
        return parent::getPath($name);
    }
}
