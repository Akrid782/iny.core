<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

CAdminMessage::showNote(Loc::getMessage('MOD_INST_OK'));
?>
<form action="<?= $APPLICATION->getCurPage() ?>">
    <div>
        <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
        <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
    </div>
</form>
