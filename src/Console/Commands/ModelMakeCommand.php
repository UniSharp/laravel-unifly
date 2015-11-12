<?php
namespace Unisharp\Unifly\Console\Commands;


class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:us-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';


    public function getStub()
    {
        return __DIR__ . '/stubs/Entity/Entity.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Entity';
    }
}
