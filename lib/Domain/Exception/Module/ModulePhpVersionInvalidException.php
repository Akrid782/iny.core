<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModulePhpVersionInvalidException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModulePhpVersionInvalidException extends ModuleValidationException
{
    public function __construct(string $invalidValue)
    {
        parent::__construct('Поддерживаемая версия php не может быть больше текущей: ' . PHP_VERSION);

        $this->invalidValue = $invalidValue;
    }
}
