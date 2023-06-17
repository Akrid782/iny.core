<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\CurrentUser;

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
    public $MODULE_GROUP_RIGHTS = 'N';

    public function __construct()
    {
        $moduleVersion = [];

        include __DIR__ . '/version.php';

        $this->MODULE_VERSION = $moduleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $moduleVersion['VERSION_DATE'];

        $this->MODULE_NAME = Loc::getMessage('INY_CORE_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('INY_CORE_MODULE_DESCRIPTION');
    }

    /**
     * @return void
     */
    public function DoInstall(): void
    {
        if (!CurrentUser::get()->isAdmin()) {
            return;
        }
    }

    /**
     * @return void
     */
    public function DoUninstall(): void
    {
    }

    /**
     * @return array
     */
    public function getEventHandlerList(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAgentHandlerList(): array
    {
        return [];
    }
}
