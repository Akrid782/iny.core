<?php

namespace INY\Core\Trait;

use INY\Core\DI\Container;
use Bitrix\Main\ObjectNotFoundException;

/**
 * Trait Singleton
 *
 * @package Trait
 */
trait Singleton
{
    /**
     * @return static
     * @throws ObjectNotFoundException
     */
    final public static function getInstance(): static
    {
        /**
         * @var static
         */
        return Container::get(static::class);
    }

    /**
     * @return bool
     */
    final public static function hasInstance(): bool
    {
        return Container::has(static::class);
    }

    final private function __construct()
    {
        $this->initContext();
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
    protected function initContext(): void
    {
    }
}
