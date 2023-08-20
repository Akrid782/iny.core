<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 */

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

CAdminMessage::ShowNote(Loc::getMessage('MOD_INST_OK'));
?>
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <div>
        <?= Loc::getMessage('INY_CORE_STEP2_INSTALLED') ?>
        <ul>
            <?php
            if ($phpunit = Option::get('iny.core', '~PHP_UNIT')) : ?>
                <li>PHPUnit: <?= $phpunit ?></li>
            <?php
            endif; ?>

            <?php
            if ($phpstan = Option::get('iny.core', '~PHP_STAN') === 'Y') : ?>
                <li>PHPStan: <?= $phpstan ?> </li>
            <?php
            endif; ?>
        </ul>
    </div>
    <hr />
    <div>
        <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
        <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
    </div>
</form>
