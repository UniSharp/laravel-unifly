<?php

namespace Unisharp\Unifly\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:entity {entity} {--for=backend} {--translatable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Entity Files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $entity = $this->argument('entity');
        $entity = ucfirst($entity);
        $for = $this->option('for', 'backend');


        // 將有 namespace 的參數切字串 例如 Backend\\SayHi -> backend/say_hi
        $target_view_path = implode(
            '/',
            array_map(
                function ($e) {
                    return Str::snake($e);
                },
                explode('\\', $entity)
            )
        );

        if ($for !== 'api') {
            \Artisan::call(
                'make:us-view',
                [
                    'name' => 'index',
                    'entity_name' => $entity,
                    '--for' => $for,
                ]
            );


            \Artisan::call(
                'make:us-view',
                [
                    'name' => 'create',
                    'entity_name' => $entity,
                    '--for' => $for,
                ]
            );

            \Artisan::call(
                'make:us-view',
                [
                    'name' => 'show',
                    'entity_name' => $entity,
                    '--for' => $for,
                ]
            );

            \Artisan::call(
                'make:us-view',
                [
                    'name' => 'edit',
                    'entity_name' => $entity,
                    '--for' => $for,
                ]
            );
        }

        if ($this->option('translatable')) {
            $table = Str::plural(Str::snake($entity));
            \Artisan::call(
                'make:model',
                [
                    'name' => 'Entity\\' . $entity
                ]
            );

            \Artisan::call(
                'make:model',
                [
                    'name' => 'Entity\\' . $entity . 'Translation'
                ]
            );

            \Artisan::call(
                'make:us-trans-migration',
                [
                    'name' => "create_{$table}_table",
                    '--create' => $table
                ]
            );
        } else {
            \Artisan::call(
                'make:model',
                [
                    'name' => 'Entity\\' . $entity,
                    '--migration' => 'default'
                ]
            );
        }

        \Artisan::call(
            'make:us-controller',
            [
                'name' => $entity . 'Controller',
                'entity_name' => $entity,
                '--for' => $for,
            ]
        );

        \Artisan::call(
            'make:us-repository',
            [
                'name' => $entity . 'Repo',
                'entity_name' => $entity,
                '--for' => $for,
            ]
        );

        \Artisan::call(
            'make:us-presenter',
            [
                'name' => $entity . 'Presenter',
                'entity_name' => $entity,
                '--for' => $for,
            ]
        );

        \Artisan::call(
            'make:us-model',
            [
                'name' => $entity,
                'entity_name' => $entity,
                '--for' => $for,
            ]
        );

        \Artisan::call(
            'make:request',
            [
                'name' => ucfirst($for) . '\\' . $entity . '\\CreateFormRequest'
            ]
        );

        \Artisan::call(
            'make:request',
            [
                'name' => ucfirst($for) . '\\' .$entity . '\\UpdateFormRequest'
            ]
        );

        \Artisan::call(
            'make:request',
            [
                'name' =>  ucfirst($for) . '\\' . $entity . '\\DestroyFormRequest'
            ]
        );
    }
}
