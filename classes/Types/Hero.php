<?php

namespace EEV\Widgets\Classes\Types;

class Hero extends WidgetType
{
    protected $name = self::HERO;

    protected function getFields() {
        return [
            'title' => [
                'label' => 'Title',
                'span' => 'full',
                'type' => 'text',
            ],
        ];
    }
}