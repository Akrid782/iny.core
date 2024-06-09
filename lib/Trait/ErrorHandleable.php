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
     * @var List<Throwable>
     */
    private static array $errorList = [];

    /**
     * @return Throwable|null
     */
    public static function getLastError(): ?Throwable
    {
        return end(self::$errorList) ?: null;
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

    private static function createError(string $message, int $code = 500): void
    {
        if ($message) {
            self::$errorList[] = new SystemException($message, $code, self::getClassPath());
        }
    }

    private static function getClassPath(): string
    {
        return (string) (new ReflectionClass(static::class))->getFileName();
    }

    private static function addException(Throwable $throwable): void
    {
        self::$errorList[] = $throwable;
    }
}
