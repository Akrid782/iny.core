<?php

namespace INY\Core\Domain\Factory;

use INY\Core\Domain\Entity\Module;
use INY\Core\Domain\Exception\ModuleValidationException;
use INY\Core\Domain\ValueObject\Module\Description;
use INY\Core\Domain\ValueObject\Module\Id;
use INY\Core\Domain\ValueObject\Module\Name;
use INY\Core\Domain\ValueObject\Module\PartnerName;
use INY\Core\Domain\ValueObject\Module\PartnerUri;
use INY\Core\Domain\ValueObject\Module\PhpVersion;

/**
 * class ModuleFactory
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Repository
 */
class ModuleFactory
{
    /**
     * @throws ModuleValidationException
     */
    public static function create(
        string $id,
        string $name,
        string $description,
        string $partnerName,
        string $partnerUri,
        float $phpVersion,
    ): Module {
        return new Module(
            new Id($id),
            new Name($name),
            new Description($description),
            new PartnerName($partnerName),
            new PartnerUri($partnerUri),
            new PhpVersion($phpVersion)
        );
    }
}
