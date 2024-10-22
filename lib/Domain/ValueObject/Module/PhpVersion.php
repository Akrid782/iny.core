<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\ArgumentException;

/**
 * class PhpVersion
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class PhpVersion
{
    /**
     * @throws ArgumentException
     */
    public function __construct(public readonly float $value)
    {
        $this->validatePhpVersion();
    }

    /**
     * @throws ArgumentException
     */
    private function validatePhpVersion(): void
    {
        if ($this->value > PHP_VERSION) {
            throw new ArgumentException('Поддерживаемая версия php не может быть больше ' . PHP_VERSION);
        }
    }
}
