<?php

namespace EEV\Frontpage;

use Backend\Widgets\Form;
use EEV\Frontpage\Classes\Widget;
use EEV\Frontpage\Components\FrontSections;
use EEV\Frontpage\Components\Widget as WidgetComponent;
use EEV\Frontpage\Controllers\WidgetController;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['EEV.Core'];

    public function registerComponents()
    {
        return [
//            WidgetComponent::class => 'widget',
            FrontSections::class => 'frontSections',
        ];
    }

    public function __construct($app)
    {
        parent::__construct($app);

        WidgetController::extendFormFields(function (Form $form, $model, $context) {
            if (!empty($model->type)) {
                $form->removeField('type');
            } else {
                $form->removeField('template');
                return;
            }

            $widget = new Widget($model->type, $model->data);

            if (!empty($widget->getType()->getDataFields())) {
                $form->addTabFields($widget->getType()->getDataFields());
            }
        });
    }

}