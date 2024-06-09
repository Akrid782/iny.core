<?php

namespace INY\Core\Util;

use CJSCore;
use Bitrix\Main\Application;

/**
 * class JSExtensionRegistration
 *
 * @package INY\Core\Util
 */
class JSExtensionRegistration
{
    public const LOCATION_BITRIX = '/bitrix/js/';
    public const LOCATION_LOCAL = '/local/js/';

    /**
     * @param string $extensionName
     *
     * @return void
     */
    public static function register(string $extensionName): void
    {
        if (self::validateNamespaceExtension($extensionName) === false) {
            return;
        }

        $extensionDir = self::createExtensionDir($extensionName);
        $extensionLocation = self::defineExtensionLocation($extensionDir);
        if (!$extensionLocation) {
            return;
        }

        CJSCore::registerExt(
            $extensionName,
            self::getConfig($extensionLocation, $extensionDir)
        );
    }

    public static function validateNamespaceExtension(string $extensionName): bool
    {
        $namespaces = explode('.', $extensionName, 2);

        return count($namespaces) > 1;
    }

    private static function createExtensionDir(string $extensionName): string
    {
        return implode('/', explode('.', $extensionName, 2));
    }

    private static function defineExtensionLocation(string $extensionDir): ?string
    {
        $rootPath = Application::getDocumentRoot();

        return match (true) {
            file_exists($rootPath . self::LOCATION_LOCAL . $extensionDir . '/config.php') => self::LOCATION_LOCAL,
            file_exists($rootPath . self::LOCATION_BITRIX . $extensionDir . '/config.php') => self::LOCATION_BITRIX,
            default => null,
        };
    }

    /**
     * @param string $extensionLocation
     * @param string $extensionDir
     *
     * @return array{js:string,css:string}
     */
    private static function getConfig(string $extensionLocation, string $extensionDir): array
    {
        $config = include(Application::getDocumentRoot() . $extensionLocation . $extensionDir . '/config.php');
        $config['js'] = $extensionLocation . $extensionDir . '/' . $config['js'];
        $config['css'] = $extensionLocation . $extensionDir . '/' . $config['css'];

        return $config;
    }
}
