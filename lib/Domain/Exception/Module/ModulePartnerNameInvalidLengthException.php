<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModulePartnerNameInvalidLengthException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModulePartnerNameInvalidLengthException extends ModuleValidationException
{
    public function __construct(string $invalidValue, int $maxLength)
    {
        parent::__construct("Имя партнера не может быть длиннее $maxLength символов.");

        $this->invalidValue = $invalidValue;
    }
}
