<?php

namespace INY\Core\Tests\PHPUnit\Validations;

use INY\Core\Validations\Validator;
use INY\Core\Tests\PHPUnit\TestCase;
use INY\Core\Validations\Serializer;
use INY\Core\Validations\Fields\StringType;

/**
 * class SerializerTest
 *
 * @package INY\Core\Tests\PHPUnit\Validations
 */
class SerializerTest extends TestCase
{
    public function testASD()
    {
        $test = [
            'NAME' => new StringType(true),
            'TEST' => new Validator([
                'NAME2' => new StringType(true),
                'NAME3' => new StringType(true),
                'NAME4' => new StringType(true, null, 5),
                'TEST' => new Validator([
                    'NAME2' => new StringType(true),
                    'TEST' => new Validator([
                        'NAME2' => new StringType(true),
                        'TEST' => new Validator([
                            'NAME2' => new StringType(true),
                        ]),
                    ]),
                ]),
            ]),
        ];

        $formData = [
            'NAME' => 67,
            'TEST' => [
                'NAME2' => 6,
                'NAME3' => '',
                'NAME4' => '4353',
            ],
        ];


        $a = (new Serializer($formData, $test))->get()->isValid;
    }
}
