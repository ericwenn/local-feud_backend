<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the "LICENSE.md"
 * file that was distributed with this source code.
 */

namespace Respect\Validation\Rules;

class HexColorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerForValidHexRgbColor
     */
    public function testHexRgbColorValuesONLYShouldReturnTrue($validHexRgbColor)
    {
        $validator = new HexColor();

        $this->assertTrue($validator->validate($validHexRgbColor));
    }

    /**
     * @dataProvider providerForInvalidHexRgbColor
     */
    public function testInvalidHexRgbColorValuesShouldReturnFalse($invalidHexRgbColor)
    {
        $validator = new HexColor();

        $this->assertFalse($validator->validate($invalidHexRgbColor));
    }

    public function providerForValidHexRgbColor()
    {
        return array(
            array('#000'),
            array('#00000F'),
            array('#123'),
            array('#123456'),
            array('#FFFFFF'),
            array('123123'),
            array('FFFFFF'),
        );
    }

    public function providerForInvalidHexRgbColor()
    {
        return array(
            array('#0'),
            array('#0000G0'),
            array('#0FG'),
            array('#1234'),
            array('#AAAAAA1'),
            array('#S'),
            array('1234'),
            array('foo'),
            array(0x39F),
            array(05),
            array(1),
            array(443),
            array(array()),
            array(new \stdClass()),
            array(null),
        );
    }
}
