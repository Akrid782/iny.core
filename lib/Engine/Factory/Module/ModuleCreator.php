<?php

namespace INY\Core\Engine\Factory\Module;

use SplFileInfo;
use IteratorAggregate;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Bitrix\Main\Localization\Loc;
use INY\Core\Trait\ErrorHandleable;
use INY\Core\Engine\Factory\Module\DTO\ModuleDTO;

/**
 * class ModuleCreator
 *
 * @package INY\Core\Engine\Module
 */
final class ModuleCreator
{
    use ErrorHandleable;

    private const TEMPLATE_PATH = '/template/module/';
    private readonly ModuleDTO $module;
    private readonly string $templateModuleFolderPath;
    private readonly string $createdModulePath;
    private readonly string $coreBitrixModulePath;

    /**
     * @param ModuleDTO $module
     */
    public function __construct(ModuleDTO $module)
    {
        $this->module = $module;
        $this->templateModuleFolderPath = dirname(__DIR__, 4) . self::TEMPLATE_PATH;
        $this->createdModulePath = $this->getCreatedModulePath();
        $this->coreBitrixModulePath = $this->getCoreBitrixModulePath();
    }

    private function getCreatedModulePath(): string
    {
        return Application::getDocumentRoot() . '/local/modules/' . $this->module->id . '/';
    }

    private function getCoreBitrixModulePath(): string
    {
        return Application::getDocumentRoot() . '/bitrix/modules/' . $this->module->id . '/';
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        if ($this->isModuleExists()) {
            self::createError(
                (string) Loc::getMessage('INY_CORE_ENGINE_MODULE_FACTORY_MODULE_CREATOR_EXISTS_ERROR', [
                    '#MODULE_ID#' => $this->module->id,
                ])
            );

            return false;
        }

        if ($this->createModule() === false) {
            Directory::deleteDirectory($this->createdModulePath);
        }

        return self::hasNotError();
    }

    private function isModuleExists(): bool
    {
        return Directory::isDirectoryExists($this->createdModulePath)
            || Directory::isDirectoryExists($this->coreBitrixModulePath);
    }

    private function createModule(): bool
    {
        $this->createModuleDir();
        $isSuccessCopy = $this->copyModuleTemplate();
        if (!$isSuccessCopy) {
            return false;
        }

        $templateKeys = $this->getTemplateKeys();
        $iteratorForCreatedModule = $this->getRecursiveIteratorForCreatedModule();

        /**
         * @var IteratorAggregate<SplFileInfo> $iteratorForCreatedModule
         */
        foreach ($iteratorForCreatedModule as $moduleFile) {
            $this->replaceTemplatesInFile($moduleFile, $templateKeys);

            if (self::hasError()) {
                return false;
            }
        }

        return true;
    }

    private function createModuleDir(): void
    {
        Directory::createDirectory($this->createdModulePath);
    }

    private function copyModuleTemplate(): bool
    {
        $hasCreated = copyDirFiles($this->templateModuleFolderPath, $this->createdModulePath, true, true);
        if (!$hasCreated) {
            self::createError(
                (string) Loc::getMessage('INY_CORE_ENGINE_MODULE_FACTORY_MODULE_CREATOR_COPY_MODULE_ERROR', [
                    '#PATH#' => $this->createdModulePath,
                ])
            );
        }

        return self::hasNotError();
    }

    /**
     * @return array<string, string|float>
     */
    private function getTemplateKeys(): array
    {
        $code = str_replace('.', '_', $this->module->id);

        return [
            'TEMPLATE_REPLACE_NAME' => $this->module->name,
            'TEMPLATE_REPLACE_DESCRIPTION' => $this->module->description,
            'TEMPLATE_REPLACE_DATE_CREATED' => date('Y-m-d H:i:s'),
            'TEMPLATE_REPLACE_MODULE_ID' => $this->module->id,
            'TEMPLATE_REPLACE_MODULE_CODE' => $code,
            'TEMPLATE_REPLACE_PREFIX' => strtoupper($code),
            'TEMPLATE_REPLACE_MIN_VERSION_PHP' => $this->module->minVersionPHP,
            'TEMPLATE_REPLACE_PARTNER_NAME' => $this->module->partnerName,
            'TEMPLATE_REPLACE_PARTNER_URI' => $this->module->partnerUri,
        ];
    }

    /**
     * @phpstan-return RecursiveIteratorIterator<RecursiveDirectoryIterator>
     */
    private function getRecursiveIteratorForCreatedModule(): RecursiveIteratorIterator
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->createdModulePath)
        );
    }

    /**
     * @param SplFileInfo                 $moduleFile
     * @param array<string, string|float> $templateKeys
     *
     * @return bool
     */
    private function replaceTemplatesInFile(SplFileInfo $moduleFile, array $templateKeys): bool
    {
        if (!$moduleFile->isFile()) {
            return false;
        }

        $contentFile = (string) file_get_contents($moduleFile->getRealPath());
        $contentFile = str_replace(array_keys($templateKeys), $templateKeys, $contentFile);

        return $this->rewriteFile($moduleFile, $contentFile);
    }

    private function rewriteFile(SplFileInfo $moduleFile, string $contentFile): bool
    {
        $isRewriteFile = rewriteFile($moduleFile->getRealPath(), $contentFile);
        if (!$isRewriteFile) {
            self::createError(
                (string) Loc::getMessage('INY_CORE_ENGINE_MODULE_FACTORY_MODULE_CREATOR_FILE_REWRITE_ERROR', [
                    '#PATH#' => $this->createdModulePath,
                ])
            );
        }

        return self::hasNotError();
    }
}
