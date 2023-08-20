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
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$mainModuleId = 'iny.core';

Bitrix\Main\Loader::includeModule($mainModuleId);

$allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($DOCUMENT_ROOT . '/local/modules/'));
$allFiles->setMaxDepth(6);
$phpFiles = new RegexIterator($allFiles, '/(\/tests\/\b)(?!.*\b\1\b)/');

$moduleId = '';
foreach ($phpFiles as $phpFile) {
    $filePathFile = $phpFile->getRealPath();
    if (stripos($filePathFile, "/{$moduleId}/") === false) {
        $moduleId = GetModuleID($filePathFile);

        if ($moduleId !== $mainModuleId) {
            Bitrix\Main\Loader::includeModule($moduleId);
        }
    }
}

spl_autoload_register(
    static function (string $className): void {
        if (mb_strpos($className, '\\Tests\\PHPUnit\\')) {
            $path = $_SERVER['DOCUMENT_ROOT'];
            $pathList = explode('\\', $className);
            $module = mb_strtolower(
                implode(
                    '.',
                    [
                        $pathList[0],
                        $pathList[1],
                    ]
                )
            );
            if (file_exists($path . '/local/modules/' . $module)) {
                $path .= '/local/modules/';
            } else {
                $path .= '/bitrix/modules/';
            }
            $path .= $module . '/tests/';
            unset($pathList[0], $pathList[1], $pathList[2]);

            if (file_exists($path)) {
                $path .= implode('/', $pathList) . '.php';
                if (file_exists($path)) {
                    require_once $path;
                }
            }
        }
    }
);
