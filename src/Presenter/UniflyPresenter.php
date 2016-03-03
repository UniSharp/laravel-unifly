<?php

namespace Unisharp\Unifly\Presenter;

use Unisharp\Unifly\Entity;

use Unisharp\FileApi\FileApi;

class UniflyPresenter
{
    public $entity;

    public function initImagePath()
    {
        $image_path = $this->entity->image_path;
        carrier()->extend('image_path', function ($filename) use ($image_path) {
            $fa = new FileApi($image_path);
            return $fa->get($filename);
        });
    }

    public function initFormData()
    {
        $formData = function ($attr) {
            if (old($attr)) {
                return old($attr);
            }

            if (!empty(d('main.entity')->$attr)) {
                return d('main.entity')->$attr;
            }

            return null;
        };

        carrier()->extend('formData', $formData);
    }
}
