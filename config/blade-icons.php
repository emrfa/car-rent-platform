<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Icon Sets
    |--------------------------------------------------------------------------
    |
    | Here you can define configurations for multiple icon sets.
    |
    | 'default' is a special key that will be used as a fallback when no
    | specific set is defined in a component.
    |
    */

    'sets' => [

        'default' => [
            /*
            |--------------------------------------------------------------------------
            | Path
            |--------------------------------------------------------------------------
            |
            | The path to the directory where the icons are stored. This can
            | be a path relative to the root of the application or an
            | absolute path.
            |
            */

            'path' => 'resources/svg',

            /*
            |--------------------------------------------------------------------------
            | Prefix
            |--------------------------------------------------------------------------
            |
            | The prefix to use for the icons in this set. This will be
            | prepended to the icon name when using the component.
            |
            | e.g. <x-icon-name />
            |
            */

            'prefix' => 'icon',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Class
    |--------------------------------------------------------------------------
    |
    | The default class to apply to all icons. This can be a string or an
    | array of classes.
    |
    */

    'class' => '',

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    |
    | The default attributes to apply to all icons. This can be an array
    | of attributes with their values.
    |
    */

    'attributes' => [
        // 'width' => 24,
        // 'height' => 24,
    ],

];