<?php

namespace INY\Core\Engine;

/**
 * class EnumServerType
 *
 * @package INY\Core\Engine
 */
enum EnumServerType: string
{
    case LOCAL = 'local';
    case DEV = 'dev';
    case STAGE = 'stage';
    case PROD = 'prod';
    case UNDEFINED = 'undefined';

    /**
     * @param string|null $type
     *
     * @return self
     */
    public static function defineServerType(?string $type): self
    {
        return match (strtolower((string) $type)) {
            self::LOCAL->value => self::LOCAL,
            self::DEV->value => self::DEV,
            self::STAGE->value => self::STAGE,
            self::PROD->value => self::PROD,
            default => self::UNDEFINED
        };
    }

    /**
     * @return array<string, self>
     */
    public static function getServerTypes(): array
    {
        return [
            self::LOCAL->value => self::LOCAL,
            self::DEV->value => self::DEV,
            self::STAGE->value => self::STAGE,
            self::PROD->value => self::PROD,
            self::UNDEFINED->value => self::UNDEFINED,
        ];
    }
}
