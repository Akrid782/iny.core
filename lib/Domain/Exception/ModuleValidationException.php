<?php

namespace INY\Core\Domain\Exception;

use Bitrix\Main\SystemException;

/**
 * class ModuleValidationException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception
 */
class ModuleValidationException extends SystemException
{
    protected string $invalidValue = '';

    public function getInvalidValue(): string
    {
        return $this->invalidValue;
    }
}
