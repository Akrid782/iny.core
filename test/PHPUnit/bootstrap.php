<?php

const NO_KEEP_STATISTIC = true;
const NOT_CHECK_PERMISSIONS = true;
const BX_NO_ACCELERATOR_RESET = true;
const BX_CRONTAB = true;
const STOP_STATISTICS = true;
const NO_AGENT_STATISTIC = 'Y';
const DisableEventsCheck = true;
const NO_AGENT_CHECK = true;

if (empty($_SERVER['DOCUMENT_ROOT'])) {
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 5);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/cli/bitrix.php';

use Bitrix\Main\Loader;
use Bitrix\Main\Application;

Loader::includeModule('iny.core');

$fileList = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(Application::getDocumentRoot() . '/local/modules/')
);
$fileList->setMaxDepth(6);
$phpFileList = new RegexIterator($fileList, '/(\/tests\/\b)(?!.*\b\1\b)/');

$moduleId = '';
foreach ($phpFileList as $phpFile) {
    $filePathFile = $phpFile->getRealPath();
    if (stripos($filePathFile, "/{$moduleId}/") === false) {
        $moduleId = GetModuleID($filePathFile);

        if ($moduleId !== 'iny.core') {
            Bitrix\Main\Loader::includeModule($moduleId);
        }
    }
}

spl_autoload_register(
    static function (string $className): void {
        if (!str_contains($className, '\\Tests\\PHPUnit\\')) {
            return;
        }

        $path = $_SERVER['DOCUMENT_ROOT'];
        $pathList = explode('\\', $className);
        $module = mb_strtolower(
            implode('.', [
                $pathList[0],
                $pathList[1],
            ])
        );

        $path .= '/bitrix/modules/';
        if (file_exists($path . '/local/modules/' . $module)) {
            $path .= '/local/modules/';
        }

        $path .= $module . '/tests/';
        unset($pathList[0], $pathList[1], $pathList[2]);

        if (!file_exists($path)) {
            return;
        }

        $path .= implode('/', $pathList) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
);
