<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 */
?>

<form action="<?= $APPLICATION->GetCurPage() ?>" name="form1" method="post">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>" />
    <input type="hidden" name="id" value="iny.core" />
    <input type="hidden" name="install" value="Y" />
    <input type="hidden" name="step" value="2" />

    <div>
        <?= Loc::getMessage('INY_CORE_STEP1_INSTALLED') ?>
        <ul>
            <li>
                <label> <?= Loc::getMessage('INY_CORE_STEP1_INSTALL_CONFIG_PHPUNIT') ?>
                    <input type="checkbox" name="install_phpunit" value="Y">
                </label>
                <label> <?= Loc::getMessage('INY_CORE_STEP1_INSTALL_CONFIG_PHPUNIT_VERSION') ?>
                    <select name="phpunit_version">
                        <option>10.2</option>
                        <option>9.5</option>
                    </select>
                </label>
            </li>
        </ul>
    </div>

    <hr />
    <div>
        <input type="submit" name="install" value="<?= Loc::getMessage('MOD_INSTALL') ?>" />
    </div>
</form>
