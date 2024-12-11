<?php

namespace INY\Core\Domain\ValueObject\Module;

use INY\Core\Domain\Exception\Module\ModulePartnerNameInvalidLengthException;

/**
 * class PartnerName
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class PartnerName
{
    private const MAX_LENGTH_NAME = 100;

    /**
     * @throws ModulePartnerNameInvalidLengthException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateLength();
    }

    /**
     * @throws ModulePartnerNameInvalidLengthException
     */
    private function validateLength(): void
    {
        if (mb_strlen($this->value) > 100) {
            throw new ModulePartnerNameInvalidLengthException($this->value, self::MAX_LENGTH_NAME);
        }
    }
}
