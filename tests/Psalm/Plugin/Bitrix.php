<?php

namespace INY\Core\Tests\Psalm\Plugin;

use Exception;
use Psalm\Config;
use SimpleXMLElement;
use Bitrix\Main\Loader;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;

/**
 * class Bitrix
 *
 * @package INY\Core\Tests\Psalm\Plugin
 */
final class Bitrix implements PluginEntryPointInterface
{
    private static ?SimpleXMLElement $config = null;

    /**
     * @param RegistrationInterface $registration
     * @param SimpleXMLElement|null $config
     *
     * @return void
     */
    public function __invoke(RegistrationInterface $registration, ?SimpleXMLElement $config = null): void
    {
    }

    /**
     * @return void
     */
    public static function loadModules()
    {
        Loader::includeModule('crm');
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function getDocumentRoot(): string
    {
        return dirname(self::getBitrixDirectory());
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function getBitrixDirectory(): string
    {
        $config = self::getConfig();

        if ($config === null) {
            throw new Exception('Plugin configuration is empty');
        }

        if (!isset($config->bitrixDir)) {
            throw new Exception('bitrixDir option not specified');
        }

        $dir = realpath((string) $config->bitrixDir);

        if ($dir === false) {
            throw new Exception('bitrixDir option value is invalid');
        }

        if (!is_dir($dir)) {
            throw new Exception('bitrixDir option value is not a directory');
        }

        return $dir;
    }

    /**
     * @return SimpleXMLElement|null
     */
    public static function getConfig(): ?SimpleXMLElement
    {
        if (self::$config === null) {
            $psalmConfig = Config::getInstance();
            foreach ($psalmConfig->getPluginClasses() as $plugin) {
                if ($plugin['class'] === '\\' . self::class) {
                    self::$config = $plugin['config'];
                }
            }
        }

        return self::$config;
    }
}
