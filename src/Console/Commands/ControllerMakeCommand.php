<?php

namespace Unisharp\Arca\Console\Commands;

use Illuminate\Filesystem\Filesystem;

class ControllerMakeCommand extends UsGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:us-controller {name} {entity_name} {--for=backend}';

    public static $SUBTYPE_BACKEND = 0;
    public static $SUBTYPE_FRONTEND = 1;
    public static $SUBTYPE_API = 2;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    protected $type = 'Controller';
    protected $for = 'backend';

    public function fire()
    {
        if (!preg_match('/Controller$/', $this->argument('name'))) {
            $this->error('Controller MUST end with "Controller"');
            return -1;
        }
        return parent::fire();
    }

    public function beforeRealFire()
    {
        $this->info('Note: You might want to add the following route: ');
        $this->info("      Route::resource('{strtolower($this->entityname)}', '{$this->argument('name')}');");
        parent::beforeRealFire();
    }

    public function getStub()
    {
        if ($this->for == 'backend') {
            return __DIR__ . 'stubs/Controller/BackendController.stub';
        }
        return __DIR__ . 'stubs/Controller/FrontendController.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $ns = $rootNamespace . '\Http\Controllers';
        if ($this->for == 'backend') {
            $ns = $ns . '\Backend';
        }
        return $ns;
    }
}