<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();

CAdminMessage::showNote(Loc::getMessage('MOD_INST_OK'));
?>

<form action="<?= $request->getRequestedPage() ?>">
    <div>
        <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
        <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
    </div>
</form>
