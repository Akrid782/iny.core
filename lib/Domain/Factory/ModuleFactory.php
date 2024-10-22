<?php

namespace INY\Core\Domain\Factory;

use Bitrix\Main\ArgumentException;
use INY\Core\Domain\Entity\Module;
use INY\Core\Domain\ValueObject\Module\Description;
use INY\Core\Domain\ValueObject\Module\Dir;
use INY\Core\Domain\ValueObject\Module\Id;
use INY\Core\Domain\ValueObject\Module\Name;
use INY\Core\Domain\ValueObject\Module\PartnerName;
use INY\Core\Domain\ValueObject\Module\PartnerUri;
use INY\Core\Domain\ValueObject\Module\PhpVersion;
use INY\Core\Trait\SingletonTrait;

/**
 * class ModuleFactory
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\Repository
 */
class ModuleFactory
{
    use SingletonTrait;

    /**
     * @throws ArgumentException
     */
    public function create(
        string $id,
        string $name,
        string $description,
        string $partnerName,
        string $partnerUri,
        string $phpVersion,
        string $dir,
    ): Module {
        return new Module(
            new Id($id),
            new Name($name),
            new Description($description),
            new PartnerName($partnerName),
            new PartnerUri($partnerUri),
            new PhpVersion($phpVersion),
            new Dir($dir),
        );
    }
}
