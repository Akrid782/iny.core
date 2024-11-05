<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\ArgumentException;

/**
 * class Name
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class Name
{
    /**
     * @throws ArgumentException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateNotEmpty();
        $this->validateLength();
    }

    /**
     * @throws ArgumentException
     */
    private function validateNotEmpty(): void
    {
        if (empty($this->value)) {
            throw new ArgumentException('Имя модуля не может быть пустым');
        }
    }

    /**
     * @throws ArgumentException
     */
    private function validateLength(): void
    {
        if (mb_strlen($this->value) < 2 || mb_strlen($this->value) > 50) {
            throw new ArgumentException('Имя модуля не может быть меньше 2 < или > 50 символов');
        }
    }
}
