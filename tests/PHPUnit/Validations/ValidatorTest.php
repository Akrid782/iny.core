<?php

namespace INY\Core\Tests\PHPUnit\Validations;

use INY\Core\Validations\Validator;
use INY\Core\Tests\PHPUnit\TestCase;
use INY\Core\Validations\Fields\StringType;

/**
 * class ValidatorTest
 *
 * @package INY\Core\PHPUnit\Tests\Validations
 */
class ValidatorTest extends TestCase
{
    public function testASD()
    {
        $test = new Validator([
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
        ]);

        $a = $test->validate([
            'NAME' => 67,
            'TEST' => [
                'NAME2' => 6,
                'NAME3' => '',
                'NAME4' => '4353',
            ],
        ]);

        $v = (array) $test;
    }
}
