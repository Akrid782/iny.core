<?php

namespace INY\Core\Engine;

use Bitrix\Main\Context;
use Bitrix\Main\Application;

/**
 * class AppEnvironment
 *
 * @package INY\Core\Engine
 */
final class Environment
{
    /**
     * @param string $envFilePath
     * @param Server $server
     */
    public function __construct(
        private readonly string $envFilePath,
        private readonly Server $server
    ) {
        $this->initEnvValues();
    }

    private function initEnvValues(): void
    {
        if (!$this->isFileEnvExists()) {
            return;
        }

        $env = Application::getInstance()->getContext()->getEnvironment();
        $env->set(
            array_merge($env->getValues(), $this->getEnvValues())
        );
    }

    private function isFileEnvExists(): bool
    {
        return file_exists($this->envFilePath);
    }

    /**
     * @return array<string, string>
     */
    private function getEnvValues(): array
    {
        return (array) parse_ini_file($this->envFilePath, true, INI_SCANNER_TYPED);
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @param string $variableName
     *
     * @return string
     */
    public function getEnvVariable(string $variableName): string
    {
        return (string) Context::getCurrent()?->getEnvironment()->get($variableName);
    }
}
