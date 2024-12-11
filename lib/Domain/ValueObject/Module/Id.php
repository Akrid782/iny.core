<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\ModuleManager;
use INY\Core\Domain\Exception\Module\ModuleIdEmptyException;
use INY\Core\Domain\Exception\Module\ModuleIdInvalidFormatException;

/**
 * class Id
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class Id
{
    /**
     * @throws ModuleIdEmptyException
     * @throws ModuleIdInvalidFormatException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateNotEmpty();
        $this->validateFormat();
    }

    /**
     * @throws ModuleIdEmptyException
     */
    private function validateNotEmpty(): void
    {
        if (empty($this->value)) {
            throw new ModuleIdEmptyException();
        }
    }

    /**
     * @throws ModuleIdInvalidFormatException
     */
    private function validateFormat(): void
    {
        if (strlen($this->value) < 2 || !ModuleManager::isValidModule($this->value)) {
            throw new ModuleIdInvalidFormatException($this->value);
        }
    }
}
