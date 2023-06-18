<?php

namespace INY\Core\Validations;

use INY\Core\Validations\Fields\ABaseType;

/**
 * class Validator
 *
 * @package INY\Core\Validations
 */
class Validator implements Validatable
{
    protected array $validationErrors = [];

    /**
     * @param ABaseType[]|Validatable $fieldType
     */
    public function __construct(protected readonly array $fieldType)
    {
    }

    /**
     * @inheritDoc
     */
    public function validate(array $dataFieldList): void
    {
        foreach ($this->fieldType as $fieldCode => $field) {
            if (!array_key_exists($fieldCode, $dataFieldList)) {
                continue;
            }

            if ($field instanceof self) {
                $field->validate($dataFieldList[$fieldCode]);

                if (!$field->isValid()) {
                    $this->validationErrors[$fieldCode] = $field->getErrors();
                }

                return;
            }

            $validationResult = $field->validate($dataFieldList[$fieldCode]);
            if ($validationResult->isValid === false) {
                $this->validationErrors[$fieldCode] = $validationResult->message;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->validationErrors;
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return empty($this->getErrors());
    }
}
