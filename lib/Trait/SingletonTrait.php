<?php

namespace INY\Core\Trait;

use INY\Core\Trait\DI\ContainerTrait;

/**
 * Trait SingletonTrait
 *
 * @package Trait
 */
trait SingletonTrait
{
    use ContainerTrait;

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
