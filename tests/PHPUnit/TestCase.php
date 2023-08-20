<?php

namespace INY\Core\PHPUnit;

use PHPUnit\Framework;
use Bitrix\Main\Application;
use Bitrix\Main\DB\SqlQueryException;

/**
 * class TestCase
 *
 * @package INY\Installations\PHPUnit
 */
class TestCase extends Framework\TestCase
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
    protected static function openTransaction(): void
    {
        Application::getConnection()->startTransaction();
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
    protected static function rollbackTransaction(): void
    {
        Application::getConnection()->rollbackTransaction();
    }
}
