<?php

namespace INY\Core\Collect;

use Closure;

/**
 * interface IInspectorable
 *
 * @package INY\Core\Collect
 */
interface IInspectorable
{
    /**
     * @param string|int $key
     *
     * @return bool
     */
    public function isExistsByKey(string|int $key): bool;

    /**
     * @param mixed $value
     * @param bool $strict
     *
     * @return bool
     *
     * @noinspection PhpUnused
     * @noinspection UnknownInspectionInspection
     */
    public function isExistsByValue(mixed $value, bool $strict = true): bool;

    /**
     * @param Closure $closure
     *
     * @return bool
     */
    public function isExists(Closure $closure): bool;
}
