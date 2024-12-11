<?php

namespace INY\Core\Domain\ValueObject\Module;

use INY\Core\Domain\Exception\Module\ModulePartnerUriInvalidFormatException;

/**
 * class PartnerUri
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class PartnerUri
{
    /**
     * @throws ModulePartnerUriInvalidFormatException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateFormat();
    }

    /**
     * @throws ModulePartnerUriInvalidFormatException
     */
    private function validateFormat(): void
    {
        if ($this->value && !filter_var($this->value, FILTER_VALIDATE_URL)) {
            throw new ModulePartnerUriInvalidFormatException($this->value);
        }
    }
}
