<?php

namespace INY\Core\Collect\Trait;

use BadMethodCallException;
use INY\Core\Collect\Extension\Converter;

/**
 * Trait Proxyable
 *
 * @package INY\Core\Collect\Trait
 *
 * @method array toArray()
 * @method array toJson()
 */
trait Proxyable
{
    /**
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        $convertResult = $this->convert($method, $parameters);
        if ($convertResult) {
            return $convertResult;
        }

        throw new BadMethodCallException(
            sprintf(
                'Method %s::%s does not exist.',
                static::class,
                $method
            )
        );
    }

    /**
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    private function convert(string $method, array $parameters): mixed
    {
        $convertMethod = get_class_methods(Converter::class);
        if (in_array($method, $convertMethod, true)) {
            return Converter::$method($this, ...$parameters);
        }

        return null;
    }
}
