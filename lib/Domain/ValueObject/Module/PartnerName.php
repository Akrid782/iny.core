<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\ArgumentException;

/**
 * class PartnerName
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class PartnerName
{
    /**
     * @throws ArgumentException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateLength();
    }

    /**
     * @throws ArgumentException
     */
    private function validateLength(): void
    {
        if (mb_strlen($this->value) > 100) {
            throw new ArgumentException('Имя партнера не может быть длиннее 100 символов');
        }
    }
}
