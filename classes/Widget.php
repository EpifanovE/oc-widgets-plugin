<?php

namespace EEV\Frontpage\Classes;

use EEV\Frontpage\Classes\Types\WidgetType;

class Widget
{
    protected $type;

    protected $data;

    protected $template;

    public function __construct($type, $data = [], $template = 'default')
    {
        $this->type = WidgetType::getTypeObject($type, $data, $template);
    }

    public function getHtml()
    {
        return $this->type->getHtml();
    }

    public function getTemplatesOptions()
    {
        return $this->type->getTemplatesOptions();
    }

    public function getType() {
        return $this->type;
    }

    public function getStyles() {
        return $this->type->getStyles();
    }
}