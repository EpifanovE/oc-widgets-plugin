<?php

namespace EEV\Frontpage\Models;

use EEV\Frontpage\Classes\Types\WidgetType;
use Model;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

class Widget extends Model
{
    use Validation, Sortable;

    public $table = 'eev_frontpage_widgets';

    public $rules = [
    ];

    protected $fillable = [
        'data',
        'name',
        'type',
        'template',
    ];

    protected $jsonable = ['data',];

    protected $widget;

    /**
     * @var WidgetType
     */
    protected $typeObject;

    public function getTypeOptions()
    {
        return WidgetType::getOptions();
    }

    public function getTemplateOptions()
    {
        if ( ! empty($this->type)) {
            return $this->typeObject->getTemplatesOptions();
        }
    }

    public function getTypeLabelAttribute() {
        return WidgetType::getTypeLabel($this->type);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function afterFetch()
    {
        if ( ! empty($this->type)) {
            $this->typeObject = WidgetType::getTypeObject($this->type, $this->data, $this->template);
        }
    }

    public function getTypeObject() {
        return $this->typeObject;
    }

    public function getHtml()
    {
        return $this->typeObject->getHtml();
    }

    public function getStyles() {
        return $this->typeObject->getStyles();
    }
}