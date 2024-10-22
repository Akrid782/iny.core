<?php

namespace INY\Core\Domain\ValueObject\Module;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\IO\Directory;

/**
 * class Dir
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\ValueObject\Module
 */
class Dir
{
    /**
     * @throws ArgumentException
     */
    public function __construct(public readonly string $value)
    {
        $this->validateDir();
    }

    /**
     * @throws ArgumentException
     */
    private function validateDir(): void
    {
        $dir = Application::getDocumentRoot() . "/$this->value/modules/";
        if (!Directory::isDirectoryExists($dir)) {
            throw new ArgumentException("Директории \"$dir\" не существует");
        }
    }
}
