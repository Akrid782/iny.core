<?php

namespace INY\Core\Trait;

use Throwable;
use ReflectionClass;
use Bitrix\Main\SystemException;

/**
 * Trait ErrorHandleable
 *
 * @package Trait
 */
trait ErrorHandleable
{
    /**
     * @var array<Throwable>
     */
    private static array $errorList = [];

    private static function addError(string $message, int $code = 500): void
    {
        if ($message) {
            self::$errorList[] = new SystemException($message, $code, self::getClassPath());
        }
    }

    private static function getClassPath(): string
    {
        return (new ReflectionClass(static::class))->getFileName();
    }

    /**
     * @return Throwable
     */
    public static function getLastError(): Throwable
    {
        return end(self::$errorList);
    }

    /**
     * @return array<Throwable>
     */
    public static function getErrorList(): array
    {
        return self::$errorList;
    }

    /**
     * @return bool
     */
    public static function hasError(): bool
    {
        return !empty(self::$errorList);
    }

    /**
     * @return bool
     */
    public static function hasNotError(): bool
    {
        return empty(self::$errorList);
    }
}
