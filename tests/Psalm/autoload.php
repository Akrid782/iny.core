<?php

use INY\Core\Tests\Psalm\Plugin\Bitrix;

if (!$_SERVER['DOCUMENT_ROOT']) {
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 5);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/cli/bootstrap.php');

Bitrix::loadModules();
