<?php

namespace Unisharp\Unifly\Console\Commands;

class TestMakeCommand extends UsGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:us-test {name} {entity_name} {--for=backend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    protected $type = 'Test';


    public function getStub()
    {
        return __DIR__ . '/stubs/test/testRepo.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\..\test\php\Repository';
    }
}