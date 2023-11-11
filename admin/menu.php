<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

global $APPLICATION;

$moduleCode = 'iny.core';
if ($APPLICATION::getGroupRight($moduleCode) === 'D') {
    return false;
}

if (!Loader::includeModule($moduleCode)) {
    return false;
}

$menuList[] = [
    'parent_menu' => 'global_menu_settings',
    'section' => 'INY_CORE',
    'sort' => 10,
    'text' => Loc::getMessage('INY_CORE_MENU_SECTION_NAME'),
    'icon' => 'fav_menu_icon_yellow',
    'page_icon' => 'fav_page_icon',
    'items_id' => 'iny_core_section',
    'items' => [
        [
            'text' => Loc::getMessage('INY_CORE_MENU_MODULE_CREATE_NAME'),
            'url' => 'iny_core_module_create.php?lang=' . LANGUAGE_ID,
            'more_url' => [
                'iny_module_create.php',
            ],
        ],
    ],
];

return $menuList;
