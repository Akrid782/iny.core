<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModuleIdInvalidFormatException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModuleIdInvalidFormatException extends ModuleValidationException
{
    public function __construct(string $invalidValue)
    {
        parent::__construct('Некорректный формат идентификатора модуля.');

        $this->invalidValue = $invalidValue;
    }
}
