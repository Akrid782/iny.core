<?php

namespace INY\Core\Validations\Fields;

use INY\Core\Validations;

/**
 * class ABaseType
 *
 * @package INY\Core\Validations\Fields
 */
abstract class ABaseType
{
    public function __construct(
        protected readonly bool $isRequired,
        protected readonly mixed $defaultValue = null
    ) {
    }

    /**
     * @param mixed $value
     *
     * @return Validations\ValidationResult
     */
    abstract public function validate(mixed $value): Validations\ValidationResult;

    /**
     * @param mixed $value
     */
    abstract public function normalize(mixed $value);
}
