<?php

namespace Unisharp\Unifly\Repository;

class UniflyRepo
{
    public $entity;

    public function search($query)
    {
        return $this->entity->paginate();
    }

    public function get($id)
    {
        return $this->entity->findOrFail($id);
    }

    public function getAll()
    {
        return $this->entity->paginate();
    }

    public function create(array $input, $locale = null)
    {
        $attrs = $this->entity->getAttrs('create');
        $trans = $this->entity->pullTransInputs($input, $attrs);
        $input = $this->entity->checkInputExist($input, $attrs);

        $entity = $this->entity->create($input);
        
        $entity->setUpTransInputs($trans, $locale);
        $entity->save();
        return $entity;
    }

    public function update($id, array $input, $locale = null)
    {
        $attrs = $this->entity->getAttrs('update');
        $trans = $this->entity->pullTransInputs($input, $attrs);
        $input = $this->entity->checkInputExist($input, $attrs);

        $entity = $this->entity->findOrFail($id);

        foreach ($input as $k => $v) {
            $entity->$k = $v;
        }

        $entity->setUpTransInputs($trans, $locale);
        $entity->save();
        return $entity;
    }

    public function delete($id)
    {
        $this->entity->destroy($id);
    }

    public function export()
    {
        \Excel::create('File Name', function ($excel) {
            $excel->sheet('Sheet Name', function ($sheet) {
            });
        })->export('xls');
    }

    public function sort($seq)
    {
        if (empty($seq)) {
            return;
        }

        foreach ($seq as $order => $id) {
            $service = $this->entity->find($id);
            $service->order = $order;
            $service->save();
        }
    }
}
