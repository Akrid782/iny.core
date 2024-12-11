<?php

namespace INY\Core\UseCase\CreateModule;

/**
 * class CreateModuleCommand
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\UseCase\CreateModule
 */
class CreateModuleCommand
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
        private readonly float $phpVersion = 8.1,
        private readonly string $partnerName = '',
        private readonly string $partnerUri = '',
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPhpVersion(): float
    {
        return $this->phpVersion;
    }

    public function getPartnerName(): string
    {
        return $this->partnerName;
    }

    public function getPartnerUri(): string
    {
        return $this->partnerUri;
    }
}
