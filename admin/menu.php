<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

$moduleCode = 'iny.core';
if (CMain::getGroupRight($moduleCode) === 'D' || !Loader::includeModule($moduleCode)) {
    return false;
}

return [
    [
        'parent_menu' => 'global_menu_services',
        'section' => 'InyCore',
        'sort' => 10,
        'text' => 'Базовый модуль (iny.core)',
        'icon' => 'sale_menu_icon_buyers_affiliate',
        'page_icon' => 'clouds_menu_icon',
        'items_id' => 'iny_core_section',
        'items' => [
            [
                'text' => 'Создание модуля',
                'url' => 'iny_core_module_creator.php?lang=' . LANGUAGE_ID,
            ],
        ],
    ],
];
