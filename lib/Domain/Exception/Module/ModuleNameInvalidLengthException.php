<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModuleNameInvalidLengthException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModuleNameInvalidLengthException extends ModuleValidationException
{
    public function __construct(string $invalidValue, int $minLength, int $maxLength)
    {
        parent::__construct("Имя не может быть меньше $minLength или более $maxLength символов.");

        $this->invalidValue = $invalidValue;
    }
}
