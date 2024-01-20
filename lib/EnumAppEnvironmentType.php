<?php

namespace INY\Core;

/**
 * class EnumAppEnvironmentType
 *
 * @package INY\Core
 */
enum EnumAppEnvironmentType: string
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
    public static function defineTypeAppEnvironmental(?string $type): self
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
