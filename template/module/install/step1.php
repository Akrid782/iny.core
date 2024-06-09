<?php

if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();
?>

<form action="<?= $request->getRequestedPage() ?>" name="form1" method="post">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" tabindex="-1" aria-hidden="true" name="lang" value="<?= LANGUAGE_ID ?>" />
    <input type="hidden" tabindex="-1" aria-hidden="true" name="id" value="TEMPLATE_REPLACE_MODULE_ID" />
    <input type="hidden" tabindex="-1" aria-hidden="true" name="install" value="Y" />
    <input type="hidden" tabindex="-1" aria-hidden="true" name="step" value="2" />
    <div>
        <input type="submit" name="install" value="<?= Loc::getMessage('MOD_INSTALL') ?>" />
    </div>
</form>
