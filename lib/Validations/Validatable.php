<?php

namespace INY\Core\Validations;

/**
 * interface Validatable
 *
 * @package INY\Core\Validations
 */
interface Validatable
{
    /**
     * @param array $dataFieldList
     *
     * @return void
     */
    public function validate(array $dataFieldList): void;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @return bool
     */
    public function isValid(): bool;
}
