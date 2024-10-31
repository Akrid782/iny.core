<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\ArgumentException;

/**
 * class PartnerUri
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class PartnerUri
{
    /**
     * @throws ArgumentException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateFormat();
    }

    /**
     * @throws ArgumentException
     */
    private function validateFormat(): void
    {
        if ($this->value && !filter_var($this->value, FILTER_VALIDATE_URL)) {
            throw new ArgumentException('URI партнера должно быть в формате scheme://domain');
        }
    }
}
