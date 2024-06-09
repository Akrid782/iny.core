<?php

if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();

CAdminMessage::showNote(Loc::getMessage('MOD_INST_OK'));
?>

<form action="<?= $request->getRequestedPage() ?>">
    <div>
        <input type="hidden" tabindex="-1" aria-hidden="true" name="lang" value="<?= LANGUAGE_ID ?>">
        <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
    </div>
</form>
