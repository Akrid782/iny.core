<?php

namespace INY\Core\Trait;

use Bitrix\Main\UserTable;

/**
 * Trait Singleton
 *
 * @package Trait
 */
trait Singleton
{
    /**
     * @var Singleton|null
     */

    protected static ?self $instance = null;

    final private function __construct()
    {
        $this->initContext();
    }

    /**
     * @return static
     */
    final public static function getInstance(): static
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @return void
     */
    final public function __wakeup(): void
    {
    }

    /**
     * @return void
     */
    final protected function __clone(): void
    {
    }

    /**
     * @return void
     */
    private function initContext(): void
    {
    }
}
