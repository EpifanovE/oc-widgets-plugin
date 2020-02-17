<?php

namespace EEV\Widgets\Components;

class Hero
{
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
}