<?php

namespace INY\Core;

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
        $this->appEnvironment = new Environment(
            Application::getDocumentRoot() . '/.env'
        );
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->appEnvironment;
    }
}
