<?php

namespace EEV\Widgets\Models;

use EEV\Widgets\Classes\Types\WidgetType;
use Model;

class Widget extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'eev_widgets_widgets';

    public $rules = [
    ];

    protected $fillable = [
        'data',
        'name',
    ];

    protected $jsonable = ['data',];

    public function getTypeOptions() {
        return WidgetType::getOptions();
    }

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}