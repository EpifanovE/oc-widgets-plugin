<?php

namespace EEV\Frontpage\Classes\Types;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use October\Rain\Support\Facades\Twig;

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
        $types = [
            self::HERO  => [
                'name'  => Lang::get('eev.frontpage::lang.types.hero.name'),
                'class' => Hero::class,
            ],
            self::ABOUT => [
                'name'  => Lang::get('eev.frontpage::lang.types.about.name'),
                'class' => About::class,
            ],
        ];

        $newTypes = [];

        $newTypes = Event::fire('eev.frontpage.widgets', [$newTypes]);

        return array_merge($types, self::getTypesArray($newTypes));
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

    public static function getTypeLabel($type)
    {
        if ( ! empty(self::getTypes()[$type])) {
            return self::getTypes()[$type]['name'];
        }
    }

    public function getHtml()
    {
        $templateName = ! empty($this->template) ? $this->template : 'default';

        if ($themeTpl = $this->getThemeHtml($templateName)) {
            return $themeTpl;
        }

        if ($pluginTpl = $this->getPluginHtml($templateName)) {
            return $pluginTpl;
        }

        return $themeTpl;
    }

    protected function getThemeHtml($templateName) {
        $themeName = Config::get('cms.activeTheme');

        $themeViewFile = themes_path() . '/' . $themeName . '/partials/frontpage/types/' . $this->name . '/' . $templateName . '.htm';

        if (file_exists($themeViewFile)) {
            return Twig::parse(file_get_contents($themeViewFile), ['data' => $this->data]);
        }

        return '';
    }

    protected function getPluginHtml($templateName) {
        $template = $this->getPluginViewsNamespace() . '::types.' . $this->name . '.' . $templateName;

        if (View::exists($template)) {
            return View::make($template, ['data' => $this->data]);
        }

        return '';
    }

    protected function getPluginViewsNamespace() {
        return 'eev.frontpage';
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

    public function getStyles()
    {
        if (method_exists($this, 'doStyles')) {
            return $this->doStyles();
        }
    }

    protected static function getTypesArray($array)
    {
        if (empty($array)) {
            return [];
        }

        $result = [];

        foreach ($array as $item) {

            if ( ! is_array($item)) {
                continue;
            }

            $result = array_merge($result, $item);
        }

        return $result;
    }

}