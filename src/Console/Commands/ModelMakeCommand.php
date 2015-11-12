<?php

namespace Unisharp\Unifly\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ModelMakeCommand extends UsGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:us-model {name} {entity_name} {--for=backend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    protected $type = 'Entity';


    public function getStub()
    {
        return __DIR__ . '/stubs/Entity/Entity.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Entity';
    }
}
