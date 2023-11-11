<?php

namespace INY\Core\Trait;

/**
 * Trait Singleton
 *
 * @package INY\Core\Trait
 */
trait Singleton
{
    protected static ?self $instance = null;

    /**
     * @return self
     */
    final public function getInstance(): static
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @return void
     */
    final protected function __wakeup(): void
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
    private function setContext(): void
    {
    }

    final private function __construct()
    {
        $this->setContext();
    }
}
