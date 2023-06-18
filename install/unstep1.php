<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

?>
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="iny.core">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <?php
    CAdminMessage::ShowMessage(Loc::getMessage('MOD_UNINST_WARN'))
    ?>
    <p><?= Loc::getMessage('MOD_UNINST_SAVE') ?></p>
    <p>
        <input type="checkbox" name="save_data" id="save_data" value="Y" checked>
        <label for="save_data"><?= GetMessage('MOD_UNINST_SAVE_TABLES') ?></label>
    </p>
    <input type="submit" name="inst" value="<?= GetMessage('MOD_UNINST_DEL') ?>">
</form>
