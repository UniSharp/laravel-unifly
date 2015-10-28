<?php
namespace Unisharp\Arca\Console\Commands;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Str;

class TranslatableMigrationCreator extends MigrationCreator
{
    protected function populateStub($name, $stub, $table)
    {
        $stub = str_replace('DummyClass', $this->getClassName($name), $stub);

        // Here we will replace the table place-holders with the table specified by
        // the developer, which is useful for quickly creating a tables creation
        // or update migration from the console instead of typing it manually.
        if (!is_null($table)) {
            $stub = str_replace('DummyTable', $table, $stub);
        }

        $stub = str_replace('DummyLowerEntity', Str::singular($table), $stub);
        return $stub;
    }

    protected function getStub($table, $create)
    {
        return $this->files->get(base_path('template/database/migration/translatable.stub'));
    }
}
