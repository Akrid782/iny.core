<?php

namespace INY\Core\Validations;

/**
 * interface Normalizable
 *
 * @package INY\Core\Validations
 */
interface Normalizable
{
    /**
     * @param array $dataFieldList
     */
    public function normalize(array $dataFieldList);
}
