<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

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

<form action="<?= $APPLICATION->getCurPage() ?>" name="form1" method="post"> <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANG ?>" />
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>" />
</form>
