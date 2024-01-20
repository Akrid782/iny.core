<?php

namespace INY\Core;

use Bitrix\Main\Context;
use Bitrix\Main\Application;
use INY\Core\Trait\Singleton;

/**
 * class Kernel
 *
 * @package INY\Core
 */
class Kernel
{
    use Singleton;

    private function initContext(): void
    {
        if (!file_exists($this->getEnvFilePath())) {
            return;
        }

        $env = Context::getCurrent()?->getEnvironment();
        $env->set(
            array_merge($env->getValues(), $this->getEnvValues())
        );
    }

    private function getEnvFilePath(): string
    {
        return Application::getDocumentRoot() . '/.env';
    }

    private function getEnvValues(): array
    {
        $envValues = [];
        $iniParams = parse_ini_file($this->getEnvFilePath(), true, INI_SCANNER_TYPED);
        foreach ($iniParams as $key => $value) {
            $envValues[$key] = $value;
        }

        return $envValues;
    }

    /**
     * Получение текущего окружения
     *
     * @return EnumAppEnvironmentType
     */
    public function getAppEnvironmentType(): EnumAppEnvironmentType
    {
        return EnumAppEnvironmentType::defineTypeAppEnvironmental(
            Context::getCurrent()?->getEnvironment()->get('APP_ENV_TYPE')
        );
    }
}
