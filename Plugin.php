<?php

namespace EEV\Frontpage;

use Backend\Widgets\Form;
use EEV\Frontpage\Components\FrontSections;
use EEV\Frontpage\Components\Widget;
use EEV\Frontpage\Controllers\WidgetController;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['EEV.Core'];

    public function registerComponents()
    {
        return [
            Widget::class => 'widget',
            FrontSections::class => 'frontSections',
        ];
    }

    public function __construct($app)
    {
        parent::__construct($app);

        WidgetController::extendFormFields(function (Form $form, $model, $context) {
            /**
             * @var \EEV\Frontpage\Models\Widget $model
             */

            if (!empty($model->type)) {
                $form->removeField('type');
            } else {
                $form->removeField('template');
                return;
            }

            if (!empty($fields = $model->getTypeObject()->getDataFields())) {
                $form->addTabFields($fields);
            }

//            dd($form);

        });
    }

}