<?php

namespace EEV\Frontpage\Models;

use EEV\Frontpage\Classes\Types\WidgetType;
use Model;
use October\Rain\Database\Traits\Sortable;

class Widget extends Model
{
    use \October\Rain\Database\Traits\Validation, Sortable;

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

    public function getTypeOptions()
    {
        return WidgetType::getOptions();
    }

    public function getTemplateOptions()
    {
        if ( ! empty($this->widget)) {
            return $this->widget->getType()->getTemplatesOptions();
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
            $this->widget = new \EEV\Frontpage\Classes\Widget($this->type, $this->data, $this->template);
        }
    }

    public function getWidget() {
        return $this->widget;
    }
}