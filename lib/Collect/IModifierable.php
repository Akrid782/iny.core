<?php

namespace INY\Core\Collect;

/**
 * interface IModifierable
 *
 * @package INY\Core\Collect
 */
interface IModifierable
{
    /**
     * @param mixed $item
     *
     * @return self
     */
    public function add(mixed $item): self;

    /**
     * @param string|int $key
     * @param mixed $item
     *
     * @return self
     */
    public function put(string|int $key, mixed $item): self;

    /**
     * @param string|int|array $keys
     *
     * @return self
     */
    public function forget(string|int|array $keys): self;

    /**
     * @param int $count
     *
     * @return self
     */
    public function pop(int $count = 1): self;

    /**
     * @param int $count
     *
     * @return self
     */
    public function shift(int $count = 1): self;
}
