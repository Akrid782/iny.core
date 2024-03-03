<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();
?>

<form action="<?= $request->getRequestedPage() ?>" name="form1" method="post">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>" />
    <input type="hidden" name="id" value="TEMPLATE_REPLACE_MODULE_CODE" />
    <input type="hidden" name="install" value="Y" />
    <input type="hidden" name="step" value="2" />
    <div>
        <input type="submit" name="install" value="<?= Loc::getMessage('MOD_INSTALL') ?>" />
    </div>
</form>
