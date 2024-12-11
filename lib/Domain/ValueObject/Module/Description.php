<?php

namespace INY\Core\Domain\ValueObject\Module;

use INY\Core\Domain\Exception\Module\ModuleDescriptionInvalidLengthException;

/**
 * class Description
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class Description
{
    private const MAX_LENGTH_NAME = 50;

    /**
     * @param string $value
     *
     * @throws ModuleDescriptionInvalidLengthException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateLength();
    }

    /**
     * @throws ModuleDescriptionInvalidLengthException
     */
    private function validateLength(): void
    {
        if (mb_strlen($this->value) <= 0 || mb_strlen($this->value) > 255) {
            throw new ModuleDescriptionInvalidLengthException($this->value, self::MAX_LENGTH_NAME);
        }
    }
}
