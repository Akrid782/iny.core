<?php

// @phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';

/**
 * @global CMain $APPLICATION
 */

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\Localization\Loc;

$moduleCode = 'iny.core';
if (!Loader::includeModule($moduleCode)) {
    $APPLICATION->authForm(Loc::getMessage('ACCESS_DENIED'));
}

if (CMain::getUserRight($moduleCode) === 'D') {
    return false;
}

$APPLICATION->SetTitle('Создание модуля');

Extension::load([
    'ui.forms',
    'ui.layout-form',
    'ui.buttons',
    'iny.settings-builder',
]);

require_once Application::getDocumentRoot() . '/bitrix/modules/main/include/prolog_admin_after.php';
?>
    <div id="test"></div>
    <div class="ui-form ui-form-section">
        <div class="ui-form-row">
            <div class="ui-form-label">
                <div class="ui-ctl-label-text">Минимальная версия php</div>
            </div>
            <div class="ui-form-content">
                <div class="ui-form-row">
                    <label class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                        <input type="text" name="MIN_PHP_VERSION" class="ui-ctl-element" placeholder="8.1"
                               value="<?= PHP_VERSION ?>">
                    </label>
                </div>
            </div>
        </div>
        <div class="ui-form-row">
            <div class="ui-form-label">
                <div class="ui-ctl-label-text">Идентификатор</div>
            </div>
            <div class="ui-form-content">
                <div class="ui-form-row">
                    <label class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                        <input type="text" name="CODE" class="ui-ctl-element" placeholder="iny.core">
                    </label>
                </div>
            </div>
        </div>
        <div class="ui-form-row">
            <div class="ui-form-label">
                <div class="ui-ctl-label-text">Наименование</div>
            </div>
            <div class="ui-form-content">
                <div class="ui-form-row">
                    <label class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                        <input type="text" name="NAME" class="ui-ctl-element" placeholder="Базовый модуль">
                    </label>
                </div>
            </div>
        </div>
        <div class="ui-form-row">
            <div class="ui-form-label">
                <div class="ui-ctl-label-text">Описание</div>
            </div>
            <div class="ui-form-content">
                <div class="ui-form-row">
                    <label class="ui-ctl ui-ctl-textarea ui-ctl-w100">
                        <textarea name="DESCRIPTION" class="ui-ctl-element ui-ctl-resize-y"
                                  placeholder="Модуль для глобального использования в bitrix"></textarea>
                    </label>
                </div>
            </div>
        </div>
        <div class="ui-form-row">
            <div class="ui-form-label">
                <div class="ui-ctl-label-text">Наименование партнера</div>
            </div>
            <div class="ui-form-content">
                <div class="ui-form-row">
                    <label class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                        <input type="text" name="PARTNER_NAME" class="ui-ctl-element" placeholder="Иванов Николай">
                    </label>
                </div>
            </div>
        </div>
        <div class="ui-form-row">
            <div class="ui-form-label">
                <div class="ui-ctl-label-text">Сайт партнера</div>
            </div>
            <div class="ui-form-content">
                <div class="ui-form-row">
                    <label class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                        <input type="text" name="PARTNER_URL" class="ui-ctl-element"
                               placeholder="https://vk.com/id140109939">
                    </label>
                </div>
            </div>
        </div>
        <div class="ui-form-row">
            <button class="ui-btn ui-btn-success">Создать</button>
        </div>
    </div>
<?php

require_once Application::getDocumentRoot() . '/bitrix/modules/main/include/epilog_admin.php';
