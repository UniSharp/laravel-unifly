<?php

namespace Unisharp\Unifly\Presenter;

use Unisharp\FileApi\FileApi;

abstract class UniflyPresenter
{
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

            if (!is_null(d('main.entity')) && !is_null(d('main.entity')->$attr)) {
                return d('main.entity')->$attr;
            }

            return null;
        };

        carrier()->extend('formData', $formData);
    }
}
