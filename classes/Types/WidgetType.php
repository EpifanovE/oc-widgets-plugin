<?php

namespace EEV\Widgets\Classes\Types;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;

abstract class WidgetType
{
    protected $name;

    protected $data;

    protected $template;

    const HERO = 'hero';

    public function __construct($data, $template)
    {
        $this->data = $data;
        $this->template = $template;
    }

    public static function getOptions()
    {
        return [
            self::HERO => Lang::get('eev.widgets::lang.components.hero.name'),
        ];
    }

    public static function getTypeObject($type, $data, $template)
    {
        $map = [
            self::HERO => Hero::class,
        ];

        if (isset($map[$type])) {
            $class = $map[$type];
            return new $class($data, $template);
        }
    }

    public function getHtml()
    {
        return View::make('eev.widgets::types.' . $this->name);
    }

    public function getTemplatesOptions()
    {
        return ['default'];
    }

    public function getDataFields()
    {
        if (!method_exists($this, 'getFields')) {
            return [];
        }

        $fields = $this->getFields();

        foreach ($fields as $key => $field) {
            $fields['data[' . $key . ']'] = $field;
            unset($fields[$key]);
        }

        return $fields;
    }

}