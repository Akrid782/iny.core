<?php

namespace INY\Core\Engine;

/**
 * class EnumEnvironmentType
 *
 * @package INY\Core\Engine
 */
enum EnumEnvironmentType: string
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
    public static function defineTypeEnvironmental(?string $type): self
    {
        return match ($type) {
            self::LOCAL->value => self::LOCAL,
            self::DEV->value => self::DEV,
            self::STAGE->value => self::STAGE,
            self::PROD->value => self::PROD,
            default => self::UNDEFINED
        };
    }
}
