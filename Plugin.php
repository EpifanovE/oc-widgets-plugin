<?php

namespace EEV\Widgets;

use EEV\Widgets\Components\Hero;
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

}