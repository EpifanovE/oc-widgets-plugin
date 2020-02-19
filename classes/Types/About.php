<?php

namespace EEV\Frontpage\Classes\Types;

class About extends WidgetType
{
    protected $name = self::ABOUT;

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