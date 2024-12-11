<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModuleIdEmptyException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModuleIdEmptyException extends ModuleValidationException
{
    public function __construct()
    {
        parent::__construct('Идентификатор модуля не может быть пустым.');
    }
}
