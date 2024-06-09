<?php

namespace INY\Core\Tests\PHPUnit;

use ReflectionClass;
use ReflectionException;
use Bitrix\Main\Application;
use Bitrix\Main\DB\SqlQueryException;

/**
 * class TestCase
 *
 * @package PHPUnit;
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    protected static bool $useTransaction = true;

    /**
     * @return void
     * @throws SqlQueryException
     */
    public static function setUpBeforeClass(): void
    {
        static::assertTrue(
            class_exists(Application::class),
            'Installations isn\'t included. Pls, set bootstrap file.'
        );

        parent::setUpBeforeClass();

        if (static::$useTransaction) {
            static::openTransaction();
        }
    }

    /**
     * @return void
     * @throws SqlQueryException
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        if (static::$useTransaction) {
            static::rollbackTransaction();
        }
    }

    /**
     * @return void
     * @throws SqlQueryException
     */
    protected static function openTransaction(): void
    {
        Application::getConnection()->startTransaction();
    }

    /**
     * @return void
     * @throws SqlQueryException
     */
    protected static function rollbackTransaction(): void
    {
        Application::getConnection()->rollbackTransaction();
    }

    /**
     * @param object|string        $class
     * @param string               $methodName
     * @param array<string, mixed> $args
     *
     * @return mixed
     * @throws ReflectionException
     */
    protected function runProtectedMethod(object|string $class, string $methodName, array $args = []): mixed
    {
        $reflectClass = new ReflectionClass($class::class);

        return $reflectClass->getMethod($methodName)->invokeArgs((object) $class, [...$args]);
    }
}
