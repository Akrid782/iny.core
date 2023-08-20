<?php

namespace INY\Core;

use Bitrix\Crm\CompanyTable;

/**
 * class Fdfs
 *
 * @package INY\Installations
 */
class Fdfs
{
    /**
     * @param array $s
     * @param integer $bn
     *
     * @return array
     */
    public static function isfsdf(array $s, int $bn)
    {
        $a = CompanyTable::getById(1);

        $b = $a['ID'];

        $sdf = [
            'A' => 435,
            'B' => 546,
        ];

        if (1 === $b) {
            echo '';
        }

        return [...$s, 'ID' => $b];
    }
}
