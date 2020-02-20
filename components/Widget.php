<?php

namespace EEV\Frontpage\Components;

use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use EEV\Frontpage\Classes\Types\WidgetType;
use EEV\Frontpage\Models\Widget as WidgetModel;
use Illuminate\Support\Facades\Event;

class Widget extends ComponentBase
{
    /**
     * @var \EEV\Frontpage\Models\Widget $widget
     */
    protected $widget;

    public function __construct(CodeBase $cmsObject = null, $properties = [])
    {
        parent::__construct($cmsObject, $properties);

        $this->widget = WidgetModel::where('id', $this->property('widget'))->active()->first();

        if (empty($this->widget)) {
            return;
        }

        $styles = $this->widget->getStyles();

        if ( ! empty($styles)) {
            Event::listen('eev.core.inlineStyles', function ($inlineStyles) use ($styles) {
                return array_merge($inlineStyles, $styles);
            });
        }
    }

    public function componentDetails()
    {
        return [
            'name'        => 'eev.frontpage::lang.components.widget.name',
            'description' => 'eev.frontpage::lang.components.widget.desc'
        ];
    }

    public function defineProperties()
    {
        return [
            'widget'    => [
                'title'             => 'eev.frontpage::lang.widget',
                'description'       => '',
                'type'              => 'dropdown',
                'required'          => true,
                'showExternalParam' => false,
                'group'             => 'eev.frontpage::lang.params',
            ],
            'adv_class' => [
                'title'             => 'eev.frontpage::lang.adv_class',
                'description'       => '',
                'default'           => '',
                'type'              => 'string',
                'showExternalParam' => false,
                'group'             => 'eev.frontpage::lang.params',
            ],
        ];
    }

    public function getWidgetOptions()
    {
        $options = WidgetModel::active()->lists('name', 'id');

        return $options;
    }

    public function getHtml()
    {
        if (empty($this->widget)) {
            return '';
        }

        return $this->widget->getHtml();
    }
}