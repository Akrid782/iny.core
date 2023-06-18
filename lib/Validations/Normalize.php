<?php

namespace INY\Core\Validations;

use INY\Core\Validations\Fields\ABaseType;

/**
 * class Normalize
 *
 * @package INY\Core\Validations
 */
class Normalize implements Normalizable
{
    protected array $normalizeResult = [];

    /**
     * @param ABaseType[]|Normalizable $fieldType
     */
    public function __construct(protected readonly array $fieldType)
    {
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function normalize(array $dataFieldList): array
    {
        foreach ($this->fieldType as $fieldCode => $field) {
            $this->normalizeResult[$fieldCode] = empty($dataFieldList[$fieldCode]) && $field instanceof self
                ? []
                : $field->normalize($dataFieldList[$fieldCode]);
        }

        return $this->normalizeResult;
    }
}
