<?php

namespace INY\Core\Engine;

use Bitrix\Main\Context;
use Bitrix\Main\Application;

/**
 * class AppEnvironment
 *
 * @package INY\Core\Engine
 */
class Environment
{
    public function __construct(
        private readonly string $envFilePath
    ) {
        $this->initEnvValues();
    }

    private function initEnvValues(): void
    {
        if (!$this->assertFileEnvExists()) {
            return;
        }

        $env = Application::getInstance()->getContext()->getEnvironment();
        $env->set(
            array_merge($env->getValues(), $this->getEnvValues())
        );
    }

    private function assertFileEnvExists(): bool
    {
        return file_exists($this->envFilePath);
    }

    private function getEnvValues(): array
    {
        return (array) parse_ini_file($this->envFilePath, true, INI_SCANNER_TYPED);
    }

    /**
     * @return EnumEnvironmentType
     */
    public function getEnvironmentType(): EnumEnvironmentType
    {
        return EnumEnvironmentType::defineTypeEnvironmental(
            (string) Context::getCurrent()?->getEnvironment()->get('APP_ENV_TYPE')
        );
    }

    /**
     * @param EnumEnvironmentType $type
     *
     * @return bool
     */
    public function assertEnvironmentType(EnumEnvironmentType $type): bool
    {
        return $this->getEnvironmentType() === $type;
    }
}
