<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ModuleManager;

/**
 * class Id
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class Id
{
    /**
     * @throws ArgumentException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateNotEmpty();
        $this->validateFormat();
    }

    /**
     * @throws ArgumentException
     */
    private function validateNotEmpty(): void
    {
        if (empty($this->value)) {
            throw new ArgumentException('ID модуля не может быть пустым');
        }
    }

    /**
     * @throws ArgumentException
     */
    private function validateFormat(): void
    {
        if (!ModuleManager::isValidModule($this->value)) {
            throw new ArgumentException('Не корректный идентификатор модуля');
        }
    }
}
