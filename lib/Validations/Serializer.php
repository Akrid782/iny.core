<?php

namespace INY\Core\Validations;

use INY\Core\Validations\Fields\ABaseType;

/**
 * class Serializer
 *
 * @package INY\Core\Validations
 */
class Serializer
{
    protected SerializerResult $serializerResult;

    /**
     * @param array $data
     * @param ABaseType[] $fieldType
     */
    public function __construct(array $data, array $fieldType)
    {
        $validator = new Validator($fieldType);
        $validator->validate($data);

        if ($validator->isValid()) {
            $normalize = new Normalize($fieldType);
            $this->serializerResult = SerializerResult::valid($normalize->normalize($data));
        } else {
            $this->serializerResult = SerializerResult::invalid($validator->getErrors());
        }
    }

    /**
     * @return SerializerResult
     */
    public function get(): SerializerResult
    {
        return $this->serializerResult;
    }
}
