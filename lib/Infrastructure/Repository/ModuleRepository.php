<?php

namespace INY\Core\Infrastructure\Repository;

use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use INY\Core\Domain\Entity\Module;
use INY\Core\Domain\Repository\ModuleRepositoryInterface;
use INY\Core\Domain\ValueObject\Module\Id;
use IteratorAggregate;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * class ModuleRepository
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Infrastructure\Repository
 */
class ModuleRepository implements ModuleRepositoryInterface
{
    private const TEMPLATE_PATH = '/template/module/';

    public function isExists(Id $id): bool
    {
        return Directory::isDirectoryExists(Application::getDocumentRoot() . '/local/modules/' . $id->value . '/')
            || Directory::isDirectoryExists(Application::getDocumentRoot() . '/bitrix/modules/' . $id->value . '/');
    }

    /**
     * @throws SystemException
     */
    public function create(Module $module): bool
    {
        $rootPath = Application::getDocumentRoot();
        $createdModulePath = $rootPath . '/' . $module->getDir()->value . '/modules/' . $module->getId()->value . '/';
        $directory = Directory::createDirectory($createdModulePath);
        if (!$directory->isExists()) {
            return false;
        }

        $templatePath = dirname(__DIR__, 3) . self::TEMPLATE_PATH;
        $hasCreated = copyDirFiles($templatePath, $createdModulePath, true, true);
        if (!$hasCreated) {
            throw new SystemException(
                (string) Loc::getMessage('INY_INFRASTRUCTURE_REPOSITORY_CREATOR_COPY_MODULE_ERROR', [
                    '#PATH#' => $createdModulePath,
                ])
            );
        }

        $code = str_replace('.', '_', $module->getId()->value);
        $templateKeys = [
            'TEMPLATE_REPLACE_NAME' => $module->getName()->value,
            'TEMPLATE_REPLACE_DESCRIPTION' => $module->getDescription()->value,
            'TEMPLATE_REPLACE_DATE_CREATED' => date('Y-m-d H:i:s'),
            'TEMPLATE_REPLACE_MODULE_ID' => $module->getId()->value,
            'TEMPLATE_REPLACE_MODULE_CODE' => $code,
            'TEMPLATE_REPLACE_PREFIX' => strtoupper($code),
            'TEMPLATE_REPLACE_MIN_VERSION_PHP' => $module->getPhpVersion()->value,
            'TEMPLATE_REPLACE_PARTNER_NAME' => $module->getPartnerName()->value,
            'TEMPLATE_REPLACE_PARTNER_URI' => $module->getPartnerUri()->value,
        ];

        /**
         * @var IteratorAggregate<SplFileInfo> $recursiveIteratorIterator
         */
        $recursiveIteratorIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($createdModulePath));
        foreach ($recursiveIteratorIterator as $moduleFile) {
            if (!$moduleFile->isFile()) {
                continue;
            }

            $contentFile = (string) file_get_contents($moduleFile->getRealPath());
            $contentFile = str_replace(array_keys($templateKeys), $templateKeys, $contentFile);

            rewriteFile($moduleFile->getRealPath(), $contentFile);
        }

        return true;
    }
}
