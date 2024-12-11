<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModuleDescriptionInvalidLengthException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModuleDescriptionInvalidLengthException extends ModuleValidationException
{
    public function __construct(string $invalidValue, int $maxLength)
    {
        parent::__construct("Описание модуля не может быть пустым или длиннее $maxLength символов");

        $this->invalidValue = $invalidValue;
    }
}
