<?php

namespace EEV\Frontpage\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class FrontSections extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'eev.frontpage::lang.components.front-sections.name',
            'description' => 'eev.frontpage::lang.components.front-sections.desc'
        ];
    }

    public function getHtml()
    {
        $widgetsCollection = \EEV\Frontpage\Models\Widget::whereIn('type', Config::get('eev.frontpage::frontTypes'))
                                                       ->active()
                                                       ->get();
        $html = '';

        foreach ($widgetsCollection as $widget) {
            $html   .= $widget->getHtml();

            $styles = $widget->getStyles();

            if ( ! empty($styles)) {
                Event::listen('eev.core.inlineStyles', function ($inlineStyles) use ($styles) {
                    return array_merge($inlineStyles, $styles);
                });
            }
        }

        return $html;
    }
}