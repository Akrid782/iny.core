<?php

namespace INY\Core\Engine\Factory\Module\DTO;

/**
 * class ModuleDTO
 *
 * @package INY\Core\Engine\Module\DTO
 */
final class ModuleDTO
{
    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $partnerName
     * @param string $partnerUri
     * @param float $minVersionPHP
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $partnerName = '',
        public readonly string $partnerUri = '',
        public readonly float $minVersionPHP = 8.1,
    ) {
    }
}
