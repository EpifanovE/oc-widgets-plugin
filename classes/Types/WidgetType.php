<?php

namespace EEV\Frontpage\Classes\Types;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;

abstract class WidgetType
{
    protected $name;

    protected $data;

    protected $template;

    const HERO = 'hero';
    const ABOUT = 'about';

    public function __construct($data, $template)
    {
        $this->data     = $data;
        $this->template = $template;
    }

    public static function getTypes()
    {
        return [
            self::HERO  => [
                'name'  => Lang::get('eev.frontpage::lang.types.hero.name'),
                'class' => Hero::class,
            ],
            self::ABOUT => [
                'name'  => Lang::get('eev.frontpage::lang.types.about.name'),
                'class' => About::class,
            ],
        ];
    }

    public static function getOptions()
    {
        return array_map(function ($item) {
            return $item['name'];
        }, self::getTypes());
    }

    public static function getTypeObject($type, $data, $template)
    {
        $map = array_map(function ($item) {
            return $item['class'];
        }, self::getTypes());

        if (isset($map[$type])) {
            $class = $map[$type];

            return new $class($data, $template);
        }
    }

    public static function getTypeLabel($type) {
        if (!empty(self::getTypes()[$type])) {
            return self::getTypes()[$type]['name'];
        }
    }

    public function getHtml()
    {
        $templateName = ! empty($this->template) ? $this->template : 'default';
        $template     = 'eev.frontpage::types.' . $this->name . '.' . $templateName;

        return View::make($template, ['data' => $this->data]);
    }

    public function getTemplatesOptions()
    {
        $pathToFiles = plugins_path() . '/eev/frontpage/views/types/' . $this->name . '/';
        $files       = scandir($pathToFiles);

        $result = [];
        foreach ($files as $key => $file) {
            if (is_file($pathToFiles . $file)) {
                $templateName          = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
                $result[$templateName] = $templateName;
            }
        }

        return $result;
    }

    public function getDataFields()
    {
        if ( ! method_exists($this, 'getFields')) {
            return [];
        }

        $fields = $this->getFields();

        foreach ($fields as $key => $field) {
            $fields['data[' . $key . ']'] = $field;
            unset($fields[$key]);
        }

        return $fields;
    }

    public function getStyles() {
        if (method_exists($this, 'doStyles')) {
            return $this->doStyles();
        }
    }

}