<?php

namespace INY\Core\Validations\Fields;

use Attribute;
use INY\Core\Validations;
use Bitrix\Main\Localization\Loc;

/**
 * class StringType
 *
 * @package INY\Core\Validations\Fields
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class StringType extends ABaseType
{
    /**
     * @param bool $isRequired
     * @param mixed|null $defaultValue
     * @param int|null $minLength
     * @param int|null $maxLength
     */
    public function __construct(
        bool $isRequired,
        mixed $defaultValue = null,
        protected readonly ?int $minLength = null,
        protected readonly ?int $maxLength = null
    ) {
        parent::__construct($isRequired, $defaultValue);
    }

    /**
     * @param mixed $value
     *
     * @return Validations\ValidationResult
     */
    public function validate(mixed $value): Validations\ValidationResult
    {
        $validationErrors = null;

        if (!is_string($value)) {
            return Validations\ValidationResult::invalid(
                Loc::getMessage('INY_CORE_VALIDATIONS_STRING_FIELD_MUST_STRING')
            );
        }

        $valueLent = mb_strlen($value);

        if ($this->minLength && $valueLent < $this->minLength) {
            $validationErrors[] = Loc::getMessage('INY_CORE_VALIDATIONS_STRING_FIELD_MUST_AT_LEAST_CHARACTERS', [
                '#LEN#' => $this->minLength,
            ]);
        }

        if ($this->maxLength && $valueLent > $this->maxLength) {
            $validationErrors[] = Loc::getMessage('INY_CORE_VALIDATIONS_STRING_FIELD_MUST_NO_MORE_CHARACTERS', [
                '#LEN#' => $this->maxLength,
            ]);
        }

        if ($this->isRequired && empty($value)) {
            $validationErrors[] = Loc::getMessage('INY_CORE_VALIDATIONS_STRING_FIELD_CANNOT_EMPTY');
        }

        if (!empty($validationErrors)) {
            return Validations\ValidationResult::invalid($validationErrors);
        }

        return Validations\ValidationResult::valid();
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function normalize(mixed $value): string
    {
        return htmlspecialcharsbx($value ?: '');
    }
}
