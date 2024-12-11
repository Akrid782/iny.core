<?php

namespace INY\Core\Domain\Exception\Module;

use INY\Core\Domain\Exception\ModuleValidationException;

/**
 * class ModulePartnerUriInvalidFormatException
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Exception\Module
 */
class ModulePartnerUriInvalidFormatException extends ModuleValidationException
{
    public function __construct(string $invalidValue)
    {
        parent::__construct('Некорректный формат URI партнера должно быть в формате scheme://domain.');

        $this->invalidValue = $invalidValue;
    }
}
