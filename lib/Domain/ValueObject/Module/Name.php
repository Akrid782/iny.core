<?php

namespace INY\Core\Domain\ValueObject\Module;

use INY\Core\Domain\Exception\Module\ModuleNameEmptyException;
use INY\Core\Domain\Exception\Module\ModuleNameInvalidLengthException;

/**
 * class Name
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class Name
{
    private const MIN_LENGTH_NAME = 2;
    private const MAX_LENGTH_NAME = 50;

    /**
     * @throws ModuleNameEmptyException
     * @throws ModuleNameInvalidLengthException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateNotEmpty();
        $this->validateLength();
    }

    /**
     * @throws ModuleNameEmptyException
     */
    private function validateNotEmpty(): void
    {
        if (empty($this->value)) {
            throw new ModuleNameEmptyException();
        }
    }

    /**
     * @throws ModuleNameInvalidLengthException
     */
    private function validateLength(): void
    {
        if (mb_strlen($this->value) < self::MIN_LENGTH_NAME || mb_strlen($this->value) > self::MAX_LENGTH_NAME) {
            throw new ModuleNameInvalidLengthException($this->value, self::MIN_LENGTH_NAME, self::MAX_LENGTH_NAME);
        }
    }
}
