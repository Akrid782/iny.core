<?php

use Bitrix\Main\IO\File;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;

if (class_exists('iny_core')) {
    return;
}

/**
 * class iny_core
 */
class iny_core extends CModule
{
    public $MODULE_ID = 'iny.core';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_URI;
    public $PARTNER_NAME;
    public $MODULE_GROUP_RIGHTS = 'N';
    public string $MODULE_FOLDER;

    public function __construct()
    {
        $moduleVersion = [];

        include __DIR__ . '/version.php';

        $this->MODULE_VERSION = $moduleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $moduleVersion['VERSION_DATE'];

        $this->MODULE_NAME = Loc::getMessage('INY_CORE_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('INY_CORE_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('INY_CORE_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('INY_CORE_PARTNER_URI');

        $this->MODULE_FOLDER = dirname(__DIR__, 1);
    }

    /**
     * @return void
     * @throws ArgumentOutOfRangeException
     */
    public function DoInstall(): void
    {
        global $APPLICATION, $step;

        if (PHP_VERSION < 8.1) {
            $APPLICATION->ThrowException(
                Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR_MINIMUM_VERSION_PHP', [
                    '#VERSION#' => PHP_VERSION,
                ])
            );
        }

        $this->checkPermission();
        $this->showError();

        switch ((int) $step) {
            case 0:
            case 1:
                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_CORE_INSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/step1.php'
                );
                break;
            case 2:
                if ($this->InstallDB()) {
                    $this->InstallFiles();
                }

                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_CORE_INSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/step2.php'
                );
                break;
        }
    }

    /**
     * @return void
     * @throws ArgumentNullException
     */
    public function DoUninstall(): void
    {
        global $APPLICATION, $step;

        $this->checkPermission();
        $this->showError();

        switch ((int) $step) {
            case 0:
            case 1:
                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_CORE_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep1.php'
                );
                break;
            case 2:
                $this->UnInstallFiles();
                $this->UnInstallDB();

                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_CORE_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep2.php'
                );
                break;
        }
    }

    /**
     * @return void
     * @throws ArgumentOutOfRangeException
     */
    public function InstallFiles(): void
    {
        $httpParamList = Application::getInstance()->getContext()->getRequest()->toArray();

        if ($httpParamList['install_phpunit'] === 'Y' && $httpParamList['phpunit_version']) {
            CopyDirFiles(
                __DIR__ . '/tests/phpunit/' . $httpParamList['phpunit_version'],
                Application::getDocumentRoot(),
                true,
                true
            );

            Option::set(
                $this->MODULE_ID,
                '~PHP_UNIT',
                $httpParamList['phpunit_version']
            );
        }

        if ($httpParamList['install_phpstan'] === 'Y' && $httpParamList['phpstan_level']) {
            $template = file_get_contents(__DIR__ . '/tests/phpstan/template.neon');
            if ($template) {
                $phpstan = str_replace(
                    [
                        '#LEVEL#',
                        '#ROOT_PATH_MODULE#',
                    ],
                    [
                        $httpParamList['phpstan_level'],
                        $this->MODULE_FOLDER,
                    ],
                    $template
                );
                file_put_contents(Application::getDocumentRoot() . '/phpstan.neon', $phpstan);

                Option::set(
                    $this->MODULE_ID,
                    '~PHP_STAN',
                    Loc::getMessage('INY_CORE_PHP_STAN', [
                        '#LEVEL#' => $httpParamList['phpstan_level'],
                    ])
                );
            }
        }
    }

    /**
     * @return void
     */
    public function UnInstallFiles(): void
    {
        if (Option::get($this->MODULE_ID, '~PHP_UNIT')) {
            File::deleteFile(Application::getDocumentRoot() . '/phpunit.xml');
        }

        if (Option::get($this->MODULE_ID, '~PHP_STAN') === 'Y') {
            File::deleteFile(Application::getDocumentRoot() . '/phpstan.neon');
        }
    }

    /**
     * @return bool
     */
    public function InstallDB(): bool
    {
        ModuleManager::registerModule($this->MODULE_ID);

        return true;
    }

    /**
     * @return void
     * @throws ArgumentNullException
     */
    public function unInstallDB(): void
    {
        $postList = Application::getInstance()->getContext()->getRequest()->toArray();

        if ($postList['save_data'] !== 'Y') {
            Option::delete($this->MODULE_ID);
        }

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    /**
     * @return void
     */
    private function checkPermission(): void
    {
        global $APPLICATION;

        if (!check_bitrix_sessid() || !CurrentUser::get()->isAdmin()) {
            $APPLICATION->ThrowException(Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR_PERMISSION'));
        }
    }

    /**
     * @return void
     */
    private function showError(): void
    {
        global $APPLICATION;

        if ($APPLICATION->GetException()) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR'),
                $this->MODULE_FOLDER . '/install/error.php'
            );
        }
    }
}
