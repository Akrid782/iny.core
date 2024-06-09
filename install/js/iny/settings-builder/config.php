<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

return [
    'css' => 'dist/app.bundle.css',
    'js' => 'dist/app.bundle.js',
    'rel' => [
        'main.polyfill.core',
        'ui.vue3',
        'ui.forms',
        'ui.layout-form',
        'ui.buttons',
        'ui.vue3.router',
        'LabelText',
    ],
    'skip_core' => true,
];
