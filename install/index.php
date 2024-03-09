<?php

use Bitrix\Main\Application;
use Bitrix\Main\EventManager;
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
    public const MIN_VERSION_PHP = 8.1;
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

        include_once __DIR__ . '/version.php';

        $this->MODULE_VERSION = $moduleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $moduleVersion['VERSION_DATE'];

        $this->MODULE_NAME = Loc::getMessage('INY_CORE_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('INY_CORE_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('INY_CORE_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('INY_CORE_PARTNER_URI');

        $this->MODULE_FOLDER = dirname(__DIR__);
    }

    /**
     * @return void
     */
    public function doInstall(): void
    {
        $this->validateModule();

        if ($this->hasError() === false) {
            $this->install();

            return;
        }

        $this->showError();
    }

    private function install(): void
    {
        global $APPLICATION, $step;

        switch ($step) {
            case 0:
            case 1:
                $APPLICATION->includeAdminFile(
                    Loc::getMessage('INY_CORE_INSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/step1.php'
                );

                return;
            case 2:
                if ($this->installDB()) {
                    $this->installFiles();
                    $this->installEvents();
                }

                $APPLICATION->includeAdminFile(
                    Loc::getMessage('INY_CORE_INSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/step2.php'
                );

                return;
            default:
                $APPLICATION->ThrowException(Loc::getMessage('INY_CORE_UNKNOWN_STEP'));
        }
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
     */
    public function installFiles(): void
    {
    }

    /**
     * @return void
     */
    public function installEvents(): void
    {
        $eventManager = EventManager::getInstance();
        foreach ($this->getEvents() as $event) {
            $eventManager->registerEventHandler(...$event);
        }
    }

    /**
     * @return void
     * @throws ArgumentNullException
     */
    public function doUnInstall(): void
    {
        $this->validateModule();

        if ($this->hasError() === false) {
            $this->unInstall();

            return;
        }

        $this->showError();
    }

    /**
     * @return void
     * @throws ArgumentNullException
     */
    private function unInstall(): void
    {
        global $APPLICATION, $step;

        switch ($step) {
            case 0:
            case 1:
                $APPLICATION->includeAdminFile(
                    Loc::getMessage('INY_CORE_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep1.php'
                );

                return;
            case 2:
                $this->unInstallEvents();
                $this->unInstallFiles();
                $this->unInstallDB();

                $APPLICATION->includeAdminFile(
                    Loc::getMessage('INY_CORE_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep2.php'
                );

                return;
            default:
                $APPLICATION->ThrowException(Loc::getMessage('INY_CORE_UNKNOWN_STEP'));
        }
    }

    /**
     * @return void
     */
    public function unInstallEvents(): void
    {
        $eventManager = EventManager::getInstance();
        foreach ($this->getEvents() as $event) {
            $eventManager->unRegisterEventHandler(...$event);
        }
    }

    /**
     * @return void
     */
    public function unInstallFiles(): void
    {
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
     * @return array
     */
    private function getEvents(): array
    {
        return [];
    }

    /**
     * @return void
     */
    private function validateModule(): void
    {
        global $APPLICATION;

        if ($this->validateVersionPHP() === false) {
            $APPLICATION->throwException(
                Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR_MINIMUM_VERSION_PHP', [
                    '#MIN_VERSION#' => self::MIN_VERSION_PHP,
                    '#VERSION#' => PHP_VERSION,
                ])
            );

            return;
        }

        if ($this->validatePermission() === false) {
            $APPLICATION->throwException(Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR_PERMISSION'));
        }
    }

    /**
     * @return bool
     */
    private function validateVersionPHP(): bool
    {
        return PHP_VERSION >= self::MIN_VERSION_PHP;
    }

    /**
     * @return bool
     */
    private function validatePermission(): bool
    {
        return check_bitrix_sessid() && CurrentUser::get()->isAdmin();
    }

    /**
     * @return void
     */
    private function showError(): void
    {
        global $APPLICATION;

        if ($this->hasError()) {
            $APPLICATION->includeAdminFile(
                Loc::getMessage('INY_CORE_MODULE_INSTALL_ERROR'),
                $this->MODULE_FOLDER . '/install/error.php'
            );
        }
    }

    /**
     * @return bool
     */
    private function hasError(): bool
    {
        global $APPLICATION;

        return (bool) $APPLICATION->getException();
    }
}
