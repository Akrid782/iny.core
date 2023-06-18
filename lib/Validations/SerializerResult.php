<?php

namespace INY\Core\Validations;

use Bitrix\Main\Web\Json;
use Bitrix\Main\ArgumentException;

/**
 * class SerializerResult
 *
 * @package INY\Core\Validations
 */
class SerializerResult
{
    /**
     * @param array $data
     * @param bool $isValid
     */
    public function __construct(public readonly array $data, public readonly bool $isValid)
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @throws ArgumentException
     */
    public function toJson(): string
    {
        return Json::encode($this->data);
    }

    public static function invalid($data): self
    {
        return new self($data, false);
    }

    public static function valid($data): self
    {
        return new self($data, true);
    }
}
