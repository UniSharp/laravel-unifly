<?php

namespace Unisharp\Arca\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;

abstract class UsGeneratorCommand extends GeneratorCommand
{
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
    protected $entityname = '';

    public function fire()
    {
        $this->entityname = $this->argument('entity_name');
        $this->entityname = ucfirst($this->entityname);
        if (in_array($this->option('for', 'backend'), ['backend', 'frontend', 'api'])) {
            $this->for = $this->option('for', 'backend');
        } else {
            $this->info('Use ' . $this->for . ' as default');
        }
        $res = $this->beforeRealFire();
        if ($res === true) {
            return;
        }
        return parent::fire();
    }

    protected function replaceClass($stub, $name)
    {
        $lower_entityname = strtolower($this->entityname);
        $stub = str_replace('DummyEntityLowerCase', $lower_entityname, $stub);
        $stub = str_replace('DummyEntity', $this->entityname, $stub);
        $stub = str_replace('DummyFor', ucfirst($this->for) . '\\', $stub);
        return parent::replaceClass($stub, $name);
    }

    protected function beforeRealFire()
    {

    }
}
