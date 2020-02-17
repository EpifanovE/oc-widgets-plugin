<?php

namespace EEV\Widgets\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class WidgetController extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'eev.widgets.manage-widgets'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('EEV.Widgets', 'widgets');
    }
}