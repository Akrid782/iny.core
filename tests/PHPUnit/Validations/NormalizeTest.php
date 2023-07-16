<?php

namespace INY\Core\Tests\PHPUnit\Validations;

use INY\Core\Validations\Normalize;
use INY\Core\Tests\PHPUnit\TestCase;
use INY\Core\Validations\Fields\StringType;

/**
 * class NormalizeTest
 *
 * @package INY\Core\PHPUnit\Tests\Validations
 */
class NormalizeTest extends TestCase
{
    public function testASD()
    {
        $test = new Normalize([
            'NAME' => new StringType(true),
            'TEST' => new Normalize([
                'NAME2' => new StringType(true),
                'NAME3' => new StringType(true),
                'NAME4' => new StringType(true, null, 5),
                'TEST' => new Normalize([
                    'NAME2' => new StringType(true),
                    'TEST' => new Normalize([
                        'NAME2' => new StringType(true),
                        'TEST' => new Normalize([
                            'NAME2' => new StringType(true),
                        ]),
                    ]),
                ]),
            ]),
        ]);

        $a = $test->normalize([
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
