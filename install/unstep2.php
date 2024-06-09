<?php

if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();
?>

<form action="<?= $request->getRequestedPage() ?>">
    <input type="hidden" tabindex="-1" aria-hidden="true" name="lang" value="<?= LANG ?>">
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
</form>
