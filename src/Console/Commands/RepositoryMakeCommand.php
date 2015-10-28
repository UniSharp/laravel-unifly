<?php

namespace Unisharp\Unifly\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class RepositoryMakeCommand extends UsGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:us-repository {name} {entity_name} {--for=backend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    protected $type = 'Repository';


    public function getStub()
    {
        return __DIR__ . '/stubs/Repository/Repo.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repository';
    }
}
