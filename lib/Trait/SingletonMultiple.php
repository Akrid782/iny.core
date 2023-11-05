<?php

namespace INY\Core\Trait;

/**
 * Trait SingletonMultiple
 *
 * @package INY\Core\Trait
 */
trait SingletonMultiple
{
    protected static ?array $instance = null;

    /**
     * @param string|int $key
     *
     * @return self
     */
    final public function getInstance(string|int $key): static
    {
        if (!static::$instance[$key]) {
            static::$instance[$key] = new static();
        }

        return static::$instance[$key];
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
