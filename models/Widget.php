<?php

namespace EEV\Widgets\Models;

use Model;

class Widget extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'eev_widgets_widgets';

    public $rules = [
    ];
}