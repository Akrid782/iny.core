<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 */

if ($exception = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage([
        'TYPE' => 'ERROR',
        'MESSAGE' => Loc::getMessage('MOD_INST_ERR'),
        'DETAILS' => $exception->GetString(),
        'HTML' => true,
    ]);
}
?>

<form action="<?= $APPLICATION->GetCurPage() ?>" name="form1" method="post"> <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANG ?>" />
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>" />
</form>
