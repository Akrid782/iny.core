<?php

// phpcs:disable SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable

if (empty($_SERVER['DOCUMENT_ROOT'])) {
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 5);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/cli/bootstrap.php';

// phpcs:enable SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Configuration;

include_once Application::getDocumentRoot() . '/bitrix/modules/main/interface/admin_lib.php';

$settings = Configuration::getInstance(GetModuleID(__DIR__));
foreach ($settings->get('scope') as $moduleID) {
    Loader::requireModule($moduleID);
}
