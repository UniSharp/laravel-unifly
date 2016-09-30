<?php

namespace Unisharp\Unifly\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ViewMakeCommand extends UsGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:us-view {name} {entity_name} {--for=backend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate view.';
    protected $type = 'View';
    protected $view_name = 'index';

    protected function beforeRealFire()
    {
        $this->view_name = $this->argument('name');
        $lower_entityname = strtolower($this->entityname);
        $p = "fe-src/pug/{$this->for}/{$lower_entityname}";
        $dir = base_path("{$p}");
        $dest = base_path("{$p}/{$this->view_name}.pug");


        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }



        if ($this->files->exists($dest)) {
            $this->error('File exists: ' . $dest);
            exit(1);
        }

        $stub = $this->files->get($this->getStub());
        $stub = parent::replaceClass($stub, $lower_entityname);
        $this->files->put($dest, $stub);
        return true;
    }

    public function getStub()
    {
        $lower_entityname = strtolower($this->entityname);
        return __DIR__ . "/stubs/views/{$this->for}/{$this->view_name}.pug";
    }
}
