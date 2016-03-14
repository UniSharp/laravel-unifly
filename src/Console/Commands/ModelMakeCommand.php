<?php
namespace Unisharp\Unifly\Console\Commands;


class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:us-model {name} {entity_name} {--migration=default} {--for=backend}';
    protected $name = 'make:us-model';
    protected $for = 'backend';
    protected $entityname = '';

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
        return parent::replaceClass($stub, $name);
    }

    protected function beforeRealFire()
    {

    }
}
