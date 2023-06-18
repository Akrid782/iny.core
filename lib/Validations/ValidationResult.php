<?php

namespace INY\Core\Validations;

/**
 * class ValidationResult
 *
 * @package INY\Core\Validations
 */
class ValidationResult
{
    /**
     * @param bool $isValid
     * @param string[]|string|null $message
     */
    public function __construct(
        public readonly bool $isValid,
        public readonly string|array|null $message = null
    ) {
    }

    /**
     * @return self
     */
    public static function valid(): self
    {
        return new self(true);
    }

    /**
     * @param $message
     *
     * @return self
     */
    public static function invalid($message): self
    {
        return new self(false, $message);
    }
}
