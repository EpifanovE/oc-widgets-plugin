<?php

namespace EEV\Frontpage\Classes\Types;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class Hero extends WidgetType
{
    protected $name = self::HERO;

    protected function getFields()
    {
        return [
            'title'            => [
                'label' => 'Title',
                'span'  => 'full',
                'type'  => 'text',
                'tab'   => Lang::get('eev.frontpage::lang.data'),
            ],
            'text'             => [
                'label'          => 'Text',
                'span'           => 'full',
                'type'           => 'richeditor',
                'toolbarButtons' => 'bold|italic|underline|color',
                'tab'            => Lang::get('eev.frontpage::lang.data'),
            ],
            'button_text'      => [
                'label' => 'Button Text',
                'span'  => 'full',
                'type'  => 'text',
                'tab'   => Lang::get('eev.frontpage::lang.data'),
            ],
            'background_image' => [
                'label'      => 'Background image',
                'type'       => 'mediafinder',
                'mode'       => 'image',
                'imageWidth' => 300,
                'tab'        => Lang::get('eev.frontpage::lang.data'),
            ],
        ];
    }

    protected function doStyles()
    {
        $styles       = [];
        $baseMediaUrl = url(Config::get('cms.storage.media.path'));

        if ( ! empty($this->data['background_image'])) {
            $styles['.hero'] = [
                'background-image' => 'url("' . $baseMediaUrl . $this->data['background_image'] . '")',
            ];
        }

        return $styles;
    }

}