<?php

namespace INY\Core\Domain\Entity;

use INY\Core\Domain\ValueObject\Module\Description;
use INY\Core\Domain\ValueObject\Module\Dir;
use INY\Core\Domain\ValueObject\Module\Id;
use INY\Core\Domain\ValueObject\Module\Name;
use INY\Core\Domain\ValueObject\Module\PartnerName;
use INY\Core\Domain\ValueObject\Module\PartnerUri;
use INY\Core\Domain\ValueObject\Module\PhpVersion;

/**
 * class Module
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Domain\Entity
 */
class Module
{
    public function __construct(
        private readonly Id $id,
        private readonly Name $name,
        private readonly Description $description,
        private readonly PartnerName $partnerName,
        private readonly PartnerUri $partnerUri,
        private readonly PhpVersion $phpVersion,
        private readonly Dir $dir
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getPartnerName(): PartnerName
    {
        return $this->partnerName;
    }

    public function getPartnerUri(): PartnerUri
    {
        return $this->partnerUri;
    }

    public function getPhpVersion(): PhpVersion
    {
        return $this->phpVersion;
    }

    public function getDir(): Dir
    {
        return $this->dir;
    }
}
