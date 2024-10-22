<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\ArgumentException;

/**
 * class Description
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class Description
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
        if (mb_strlen($this->value) > 255) {
            throw new ArgumentException('Описание модуля не может быть длиннее 255 символов');
        }
    }
}
