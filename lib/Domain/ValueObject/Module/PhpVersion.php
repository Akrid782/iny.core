<?php

namespace INY\Core\Domain\ValueObject\Module;

use INY\Core\Domain\Exception\Module\ModulePhpVersionInvalidException;

/**
 * class PhpVersion
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class PhpVersion
{
    /**
     * @throws ModulePhpVersionInvalidException
     */
    public function __construct(public readonly float $value)
    {
        $this->validatePhpVersion();
    }

    /**
     * @throws ModulePhpVersionInvalidException
     */
    private function validatePhpVersion(): void
    {
        if ($this->value > PHP_VERSION) {
            throw new ModulePhpVersionInvalidException($this->value);
        }
    }
}
