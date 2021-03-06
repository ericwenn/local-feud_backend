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

class FalseValTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validFalseProvider
     */
    public function testShouldValidatePatternAccordingToTheDefinedLocale($input)
    {
        $rule = new FalseVal();

        $this->assertTrue($rule->validate($input));
    }

    public function validFalseProvider()
    {
        return array(
            array(false),
            array(0),
            array('0'),
            array('false'),
            array('off'),
            array('no'),
        );
    }

    /**
     * @dataProvider invalidFalseProvider
     */
    public function testShouldNotValidatePatternAccordingToTheDefinedLocale($input)
    {
        $rule = new FalseVal();

        $this->assertFalse($rule->validate($input));
    }

    public function invalidFalseProvider()
    {
        return array(
            array(true),
            array(1),
            array('1'),
            array('true'),
            array('on'),
            array('yes'),
        );
    }
}
