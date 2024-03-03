<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\ArgumentNullException;

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
     */
    public function doInstall(): void
    {
        global $APPLICATION, $step;

        if (PHP_VERSION < 8.1) {
            $APPLICATION->throwException(
                Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR_MINIMUM_VERSION_PHP', [
                    '#VERSION#' => PHP_VERSION,
                ])
            );
        }

        $this->checkPermission();
        $this->showError();

        switch ($step) {
            case 0:
            case 1:
                $APPLICATION->includeAdminFile(
                    Loc::getMessage('INY_CORE_INSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/step1.php'
                );
                break;
            case 2:
                if ($this->installDB()) {
                    $this->installFiles();
                }

                $APPLICATION->includeAdminFile(
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
    public function doUninstall(): void
    {
        global $APPLICATION, $step;

        $this->checkPermission();
        $this->showError();

        switch ((int) $step) {
            case 0:
            case 1:
                $APPLICATION->includeAdminFile(
                    Loc::getMessage('INY_CORE_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep1.php'
                );
                break;
            case 2:
                $this->unInstallFiles();
                $this->unInstallDB();

                $APPLICATION->includeAdminFile(
                    Loc::getMessage('INY_CORE_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep2.php'
                );
                break;
        }
    }

    /**
     * @return void
     */
    public function installFiles(): void
    {
    }

    /**
     * @return void
     */
    public function unInstallFiles(): void
    {
    }

    /**
     * @return bool
     */
    public function installDB(): bool
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
            $APPLICATION->throwException(Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR_PERMISSION'));
        }
    }

    /**
     * @return void
     */
    private function showError(): void
    {
        global $APPLICATION;

        if ($APPLICATION->getException()) {
            $APPLICATION->includeAdminFile(
                Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR'),
                $this->MODULE_FOLDER . '/install/error.php'
            );
        }
    }
}
