<?php

namespace INY\Core\Trait;

/**
 * Trait SingletonMultiple
 *
 * @package Trait
 */
trait SingletonMultiple
{
    /**
     * @var array<string|int, static>
     */
    protected static array $instance = [];

    /**
     * @param string|int $key
     *
     * @return static
     */
    final public static function getInstance(string|int $key): static
    {
        if (!static::$instance[$key]) {
            static::$instance[$key] = new static();
        }

        return static::$instance[$key];
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

    final private function __construct()
    {
        $this->initContext();
    }
}
