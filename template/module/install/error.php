<?php

if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();

/**
 * @var CMain $APPLICATION
 */

if ($exception = $APPLICATION->getException()) {
    CAdminMessage::showMessage([
        'TYPE' => 'ERROR',
        'MESSAGE' => Loc::getMessage('MOD_INST_ERR'),
        'DETAILS' => $exception->getString(),
        'HTML' => true,
    ]);
}
?>

<form action="<?= $request->getRequestedPage() ?>" name="form1" method="post">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" tabindex="-1" aria-hidden="true" name="lang" value="<?= LANG ?>" />
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>" />
</form>
