<?php

namespace EEV\Widgets;

use Backend\Widgets\Form;
use EEV\Widgets\Classes\Types\WidgetType;
use EEV\Widgets\Classes\Widget;
use EEV\Widgets\Components\Hero;
use EEV\Widgets\Controllers\WidgetController;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['EEV.Core'];

    public function registerComponents()
    {
        return [
            Hero::class => 'hero',
        ];
    }

    public function __construct($app)
    {
        parent::__construct($app);

        WidgetController::extendFormFields(function (Form $form, $model, $context) {
            if (!empty($model->type)) {
                $form->removeField('type');
            } else {
                return;
            }

            $widget = new Widget($model->type, $model->data);

            if (!empty($widget->getType()->getDataFields())) {
                $form->addFields($widget->getType()->getDataFields());
            }
        });
    }

}