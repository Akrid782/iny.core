<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();

?>
<form action="<?= $request->getRequestedPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="iny.core">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <?php
    CAdminMessage::showMessage(Loc::getMessage('MOD_UNINST_WARN'))
    ?>
    <p><?= Loc::getMessage('MOD_UNINST_SAVE') ?></p>
    <p>
        <input type="checkbox" name="save_data" id="save_data" value="Y" checked>
        <label for="save_data">
            <?= Loc::getMessage('MOD_UNINST_SAVE_TABLES') ?>
        </label>
    </p>
    <input type="submit" name="inst" value="<?= Loc::getMessage('MOD_UNINST_DEL') ?>">
</form>
