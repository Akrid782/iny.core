<?php

namespace INY\Core\Collect;

/**
 * interface IReadable
 *
 * @package INY\Core\Collect
 */
interface IReadable
{
    /**
     * @param string|int $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getItem(string|int $key, mixed $default = null): mixed;

    /**
     * @return self
     */
    public function getKeys(): self;

    /**
     * @return self
     */
    public function getValues(): self;

    /**
     * @param mixed|callable $value
     * @param bool $strict
     *
     * @return int|string|bool
     */
    public function search(mixed $value, bool $strict = true): int|string|bool;
}
