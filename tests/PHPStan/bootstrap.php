<?php

if (!$_SERVER['DOCUMENT_ROOT']) {
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 5);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/cli/bootstrap.php');

spl_autoload_register(
    static function (string $className): void {
        $path = $_SERVER['DOCUMENT_ROOT'];
        $pathList = explode('\\', $className);

        if ($pathList[0] !== 'Bitrix') {
            $module = mb_strtolower(
                implode('.', [
                    $pathList[0],
                    $pathList[1],
                ])
            );
        } else {
            $module = $pathList[1];
        }

        \Bitrix\Main\Loader::includeModule($module);

        \Bitrix\Main\Entity\

        if (file_exists($path . '/local/modules/' . $module)) {
            $path .= '/local/modules/';
        } else {
            $path .= '/bitrix/modules/';
        }
        $path .= $module . '/lib/';
        unset($pathList[0], $pathList[1], $pathList[2]);

        if (file_exists($path)) {
            $path .= implode('/', $pathList) . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }
);
