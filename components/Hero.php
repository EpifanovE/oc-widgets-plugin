<?php

namespace EEV\Widgets\Components;

use Cms\Classes\ComponentBase;
use EEV\Widgets\Classes\Types\WidgetType;
use EEV\Widgets\Models\Widget;

class Hero extends ComponentBase
{
    /**
     * @var WidgetType $widget
     */
    protected $widget;

    public function componentDetails()
    {
        return [
            'name' => 'eev.widgets::lang.components.hero.name',
            'description' => 'eev.widgets::lang.components.hero.desc'
        ];
    }

    public function defineProperties()
    {
        return [
            'widget' => [
                'title' => 'eev.widgets::lang.widget',
                'description' => '',
                'type' => 'dropdown',
                'required' => true,
                'showExternalParam' => false,
                'group' => 'eev.widgets::lang.params',
            ],
            'adv_class' => [
                'title' => 'eev.widgets::lang.adv_class',
                'description' => '',
                'default' => '',
                'type' => 'string',
                'showExternalParam' => false,
                'group' => 'eev.widgets::lang.params',
            ],
        ];
    }

    public function getWidgetOptions()
    {
        $options = Widget::active()->lists('name', 'id');
        return $options;
    }

    public function getTemplateOptions()
    {
        if (!empty($this->widget)) {
            return $this->widget->getTemplatesOptions();
        }
    }

    public function onRun()
    {
        if (!empty($this->property('widget'))) {
            $data = Widget::find($this->property('widget'));
            $this->widget = new \EEV\Widgets\Classes\Widget(WidgetType::HERO, $data, $this->property('template'));
        }
    }

    public function getHtml()
    {
        return $this->widget->getHtml();
    }
}