<?php

namespace INY\Core;

use INY\Core\Engine\Server;
use Bitrix\Main\Application;
use INY\Core\Trait\Singleton;
use INY\Core\Engine\Environment;

/**
 * class Kernel
 *
 * @package INY\Core
 */
class Kernel
{
    use Singleton;

    private readonly Environment $appEnvironment;

    private function initContext(): void
    {
        $pathEnv = Application::getDocumentRoot() . '/.env';

        $this->appEnvironment = new Environment(
            $pathEnv,
            new Server($this)
        );
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->appEnvironment;
    }

    /**
     * @return bool
     */
    public static function hasInstance(): bool
    {
        return isset(self::$instance);
    }
}
