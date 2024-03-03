<?php

namespace INY\Core\Engine;

use INY\Core\Kernel;
use Bitrix\Main\Context;

/**
 * class Server
 *
 * @package INY\Core\Engine
 */
final class Server
{
    private const SERVER_TYPE = 'SERVER_TYPE';

    /**
     * @param Kernel $kernel
     */
    public function __construct(
        private readonly Kernel $kernel
    ) {
    }

    /**
     * @return Server|null
     */
    public static function getCurrent(): ?Server
    {
        return Kernel::hasInstance()
            ? Kernel::getInstance()->getEnvironment()->getServer()
            : null;
    }

    /**
     * @return Kernel
     */
    public function getKernel(): Kernel
    {
        return $this->kernel;
    }

    /**
     * @return array<string, EnumServerType>
     */
    public function getServerTypes(): array
    {
        return EnumServerType::getServerTypes();
    }

    /**
     * @param EnumServerType $type
     *
     * @return bool
     */
    public function assertServerType(EnumServerType $type): bool
    {
        return $this->getCurrentServerType() === $type;
    }

    /**
     * @return EnumServerType
     */
    public function getCurrentServerType(): EnumServerType
    {
        return EnumServerType::defineServerType(
            (string) Context::getCurrent()?->getEnvironment()->get(self::SERVER_TYPE)
        );
    }
}
