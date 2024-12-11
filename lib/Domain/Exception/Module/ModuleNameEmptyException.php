<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModuleNameEmptyException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModuleNameEmptyException extends ModuleValidationException
{
    public function __construct()
    {
        parent::__construct('Имя модуля не может быть пустым.');
    }
}
