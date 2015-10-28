<?php
namespace Unisharp\Unifly\Console\Commands;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Foundation\Composer;

class TranslatableMigrationMakeCommand extends MigrateMakeCommand
{
    protected $signature = 'make:us-trans-migration {name : The name of the migration.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}
        {--path= : The location where the migration file should be created.}';

    protected $creator;
    protected $composer;

    public function __construct(TranslatableMigrationCreator $creator, Composer $composer)
    {
        parent::__construct($creator, $composer);

        $this->creator = $creator;
        $this->composer = $composer;
    }
}
