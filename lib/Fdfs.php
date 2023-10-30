<?php

namespace INY\Core;

use Bitrix\Main\Loader;
use Bitrix\Crm\CompanyTable;
use Bitrix\Main\LoaderException;

/**
 * class Fdfs
 *
 * @package INY\Installations
 */
class Fdfs
{
    /**
     * @param array<int, string> $s
     * @param int $bn
     *
     * @return array
     * @throws LoaderException
     */
    public static function isfsdf(array $s, $bn): array
    {
        Loader::includeModule('crm');

        $bb = $s['str'];

        $a = CompanyTable::getById(1)->fetch();

        $b = $a['ID'];

        $b = $bn;


        $bnb = $b;


        $sdf = [
            'A' => 435,
            'B' => 546,
        ];

        if (1 === $b) {
            echo '';
        }

        CompanyTable::getById(11);

        return [...$s, ...$bb, 'ID' => $b];
    }
}
