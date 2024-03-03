<?php

namespace INY\Core\Collect\Extension;

use ReflectionProperty;
use ReflectionException;
use Bitrix\Main\Web\Json;
use INY\Core\Collect\AArray;
use Bitrix\Main\ArgumentException;

/**
 * class Converter
 *
 * @package INY\Core\Collect\Extension
 */
class Converter
{
    /**
     * @param AArray $instance
     *
     * @return array
     * @throws ReflectionException
     */
    public static function toArray(AArray $instance): array
    {
        return self::getPropertyValue($instance);
    }

    /**
     * @param AArray $instance
     *
     * @return string
     * @throws ReflectionException
     * @throws ArgumentException
     */
    public static function toJson(AArray $instance): string
    {
        return Json::encode(self::getPropertyValue($instance));
    }

    /**
     * @param AArray $class
     *
     * @return mixed
     * @throws ReflectionException
     */
    private static function getPropertyValue(AArray $class): mixed
    {
        return (new ReflectionProperty($class, 'items'))->getValue($class); //NOSONAR
    }
}
