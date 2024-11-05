<?php

// phpcs:disable SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
if (empty($_SERVER['DOCUMENT_ROOT'])) {
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 5);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/cli/bootstrap.php';

// phpcs:enable SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable

use Bitrix\Main\Application;
use Bitrix\Main\Loader;

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

        $path = Application::getDocumentRoot();
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
