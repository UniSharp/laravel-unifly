<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GeneratorController extends Controller
{
    private $storage;

    private $entity_name;
    private $entity_name_snake;
    private $entity_name_studly;
    private $migration_suffix;
    private $arr_columns = [];

    private $for = 'backend';

    public function __construct()
    {
        $this->storage = \Storage::disk('local');

        $this->entity_name = request('name_en');
        $this->entity_name_snake = snake_case($this->entity_name);
        $this->entity_name_studly = studly_case($this->entity_name);
        $this->migration_suffix = "create_" . str_plural($this->entity_name_snake) . "_table";
        $this->arr_columns = request('columns');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mixins()
    {
        $jade_content = $this->storage->get('fe-src/jade/backend/partial/mixins.jade');

        $input_begin_str = "//======[ Input fields ]======";

        $input_section = substr($jade_content, strpos($jade_content, $input_begin_str) + strlen($input_begin_str));

        $arr_mixin_names = [];
        $mixin_sections = explode('mixin ', $input_section);
        foreach ($mixin_sections as $index => $mixin_content) {
            if ($index == 0) {
                continue;
            }

            array_push($arr_mixin_names, substr($mixin_content, 0, strpos($mixin_content, '(')));
        }

        return $arr_mixin_names;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mixins = $this->mixins();
        $data_types = ['string', 'integer', 'text', 'timestamp'];

        return view('unifly')->with(compact('mixins', 'data_types'));
    }

    public function createRoute()
    {
        $entity_name = $this->entity_name;

        $file_path = "unifly.json";
        $old_unifly_entities = json_decode($this->storage->get($file_path));

        $entity_data = new \stdClass;
        $entity_data->entity_name = $this->entity_name;
        $entity_data->entity_name_tw = request('name_tw');
        $entity_data->columns = request('columns');
        $entity_data->features = request('features');
        array_push($old_unifly_entities, $entity_data);

        \File::put(base_path($file_path), json_encode($old_unifly_entities, JSON_PRETTY_PRINT));

        return 'OK';
    }
    public function createModel()
    {
        $entity_name = $this->entity_name;
        $need_translation = false;

        \Artisan::call(
            'make:us-model',
            [
                'name' => 'Entity\\' . $this->entity_name_studly,
                'entity_name' => $entity_name
            ]
        );

        $file_path = "app/Entity/" . $this->entity_name_studly . ".php";
        $old_form = $this->storage->get($file_path);

        \File::put(base_path($file_path), $this->getNewModelContent($file_path));

        if ($need_translation) {
            \Artisan::call(
                'make:us-model',
                [
                    'name' => 'Entity\\' . $this->entity_name_studly . 'Translation',
                    'entity_name' => $entity_name
                ]
            );
        }

        return 'OK';
    }
    public function createController()
    {
        $entity_name = $this->entity_name;
        \Artisan::call(
            'make:us-controller',
            [
                'name' => $this->entity_name_studly . 'Controller',
                'entity_name' => $entity_name,
                '--for' => $this->for,
            ]
        );
        return 'OK';
    }
    public function createPresenter()
    {
        $entity_name = $this->entity_name;
        \Artisan::call(
            'make:us-presenter',
            [
                'name' => $this->entity_name_studly . 'Presenter',
                'entity_name' => $entity_name,
                '--for' => $this->for,
            ]
        );
        return 'OK';
    }
    public function createRepository()
    {
        $entity_name = $this->entity_name;
        \Artisan::call(
            'make:us-repository',
            [
                'name' => $this->entity_name_studly . 'Repo',
                'entity_name' => $entity_name,
                '--for' => $this->for,
            ]
        );
        return 'OK';
    }
    public function createMigration()
    {
        $entity_name = $this->entity_name;

        $need_translation = false;

        if ($need_translation) {
            \Artisan::call(
                'make:us-trans-migration',
                [
                    'name' => $this->migration_suffix,
                    '--create' => str_plural($this->entity_name_snake)
                ]
            );
        } else {
            \Artisan::call(
                'make:migration',
                [
                    'name' => $this->migration_suffix,
                    '--create' => str_plural($this->entity_name_snake)
                ]
            );

            $file_path = $this->getMigrationPath()[0];

            \File::put(base_path($file_path), $this->getNewMigrationContent($file_path));

            \Artisan::call('migrate');
        }
        return 'OK';
    }
    public function createFormRequest()
    {
        $form_request_prefix = ucfirst($this->for) . '\\' . $this->entity_name_studly;
        $arr_actions = ['Store', 'Update', 'Destroy'];

        foreach ($arr_actions as $action) {
            \Artisan::call(
                'make:request',
                [
                    'name' => $form_request_prefix . '\\' . $action . 'FormRequest'
                ]
            );
        }
        return 'OK';
    }
    public function createView()
    {
        $entity_name = $this->entity_name;
        $arr_view_name = ['index', 'create', 'show', 'edit'];
        $for = $this->for;

        foreach ($arr_view_name as $view_name) {
            \Artisan::call(
                'make:us-view',
                [
                    'name' => $view_name,
                    'entity_name' => $entity_name,
                    '--for' => $for,
                ]
            );
        }

        foreach (['create', 'edit'] as $view_name) {
            $file_path = "fe-src/jade/backend/{$entity_name}/{$view_name}.jade";
            $old_form = $this->storage->get($file_path);

            \File::put(base_path($file_path), $this->getNewFormContent($file_path));
        }

        return 'OK';
    }

    private function getNewModelContent($file_path)
    {
        $text = $this->storage->get($file_path);

        $old_columns = "'name', 'description', 'quantity', 'time', 'type', 'enabled'";

        $arr_new_columns = [];
        foreach ($this->arr_columns as $column) {
            if (in_array('', $column)) {
                continue;
            }
            array_push($arr_new_columns, "'{$column['column_name']}'");
        }

        $new_columns_formatted = join($arr_new_columns, ', ');
        $new_model_content = str_replace($old_columns, $new_columns_formatted, $text);

        return $new_model_content;
    }

    private function getNewMigrationContent($file_path)
    {
        $text = $this->storage->get($file_path);

        $old_schemas = "\$table->increments('id');\n";

        $arr_new_schemas = [$old_schemas];
        foreach ($this->arr_columns as $column) {
            if (in_array('', $column)) {
                continue;
            }
            array_push($arr_new_schemas, "\$table->{$column['data_type']}('{$column['column_name']}')->comment('{$column['comment']}');\n");
        }

        $new_schemas_formatted = join($arr_new_schemas, str_repeat(' ', 12));
        $new_migration_content = str_replace($old_schemas, $new_schemas_formatted, $text);

        return $new_migration_content;
    }

    private function getNewFormContent($file_path)
    {
        $text = $this->storage->get($file_path);

        $old_mixins_start = "+input('name'";
        $old_mixins_end = "+radio('on', '是否上架', \"\$yn\", \"\$on\")\n";
        $start = strpos($text, $old_mixins_start);
        $end = strpos($text, $old_mixins_end) + strlen($old_mixins_end);
        $mixins_in_template = substr($text, $start, $end - $start);

        $arr_new_mixins = [];
        foreach ($this->arr_columns as $column) {
            array_push($arr_new_mixins, "+{$column['mixin']}('{$column['column_name']}', '{$column['comment']}')\n");
        }

        $new_mixins_formatted = join($arr_new_mixins, str_repeat(' ', 6));
        $new_view_content = str_replace($mixins_in_template, $new_mixins_formatted, $text);

        return $new_view_content;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $entity_name = $this->entity_name;
        $entity_class_name = $this->entity_name_studly;

        $arr_files = [
            'app/Entity/' . $entity_class_name . '.php',
            'app/Http/Controllers/Backend/' . $entity_class_name . 'Controller.php',
            'app/Presenter/' . $entity_class_name . 'Presenter.php',
            'app/Repository/' . $entity_class_name . 'Repo.php'
        ];

        $arr_files = array_merge($arr_files, $this->getMigrationPath());

        $arr_directories = [
            'app/Http/Requests/Backend/' . $entity_class_name,
            'fe-src/jade/backend/' . $entity_name
        ];

        foreach ($arr_files as $file_path) {
            if (!is_null($file_path) && $this->storage->exists($file_path)) {
                $this->storage->delete($file_path);
            }
        }

        foreach ($arr_directories as $directory_path) {
            if (!is_null($directory_path) && $this->storage->exists($directory_path)) {
                $this->storage->deleteDirectory($directory_path);
            }
        }
    }

    private function getMigrationPath()
    {
        $arr_migration_to_delete = [];

        foreach ($this->storage->files('database/migrations/') as $migration_name) {
            if (str_contains($migration_name, $this->migration_suffix)) {
                $arr_migration_to_delete[] = $migration_name;
            }
        }

        return $arr_migration_to_delete;
    }
}
