## Overriding views
```
[theme-folder]/partials/frontpage/types/[widget-name]/[template-name].htm
```

## New widget type
### Event
```
Event::listen('eev.frontpage.widgets', function ($types) {
    return array_merge($types, [
        'newType' => [
            'name'  => 'New Type',
            'class' => NewWidgetType::class,
        ],
    ]);
});
```
### Type Class
```
use EEV\Frontpage\Classes\Types\WidgetType;

class NewType extends WidgetType
{
    protected function getFields()
    {
        return [
            'title'            => [
                'label' => 'Title',
                'span'  => 'full',
                'type'  => 'text',
                'tab'   => 'Title',
            ],
        ];
    }

    protected function getPluginViewsNamespace()
    {
        return 'vendor.plugin';
    }
}
```