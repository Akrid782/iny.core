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
     * @param array<string, string> $s
     *
     * @return array<string, string>
     */
    public static function isfsdf(array $s): array
    {
        $a = CompanyTable::getById(1);

        $b = $a['ID'];

        return [...$s, 'ID' => $b];
    }
}
