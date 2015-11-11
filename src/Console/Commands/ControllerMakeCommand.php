<?php

namespace Unisharp\Unifly\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

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
            return __DIR__ . '/stubs/Controller/BackendController.stub';
        } elseif ($this->for == 'api') {
            return __DIR__ . '/stubs/Controller/ApiController.stub';
        }
        return __DIR__ . '/stubs/Controller/FrontendController.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $ns = $rootNamespace . '\Http\Controllers';
        $specifyNamespace = ['backend', 'api'];

        if (in_array($this->for, $specifyNamespace)) {
            $ns .= '\\' . Str::studly($this->for);
        }

        return $ns;
    }
}
