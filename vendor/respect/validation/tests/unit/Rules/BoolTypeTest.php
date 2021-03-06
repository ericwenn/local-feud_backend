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

class BoolTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testBoolTypeValuesONLYShouldReturnTrue()
    {
        $validator = new BoolType();
        $this->assertTrue($validator->__invoke(''));
        $this->assertTrue($validator->__invoke(true));
        $this->assertTrue($validator->__invoke(false));
        $this->assertTrue($validator->assert(true));
        $this->assertTrue($validator->assert(false));
        $this->assertTrue($validator->check(true));
        $this->assertTrue($validator->check(false));
    }

    /**
     * @expectedException Respect\Validation\Exceptions\BoolTypeException
     */
    public function testInvalidBoolTypeShouldRaiseException()
    {
        $validator = new BoolType();
        $this->assertFalse($validator->check('foo'));
    }

    public function testInvalidBoolTypeValuesShouldReturnFalse()
    {
        $validator = new BoolType();
        $this->assertFalse($validator->__invoke('foo'));
        $this->assertFalse($validator->__invoke(123123));
        $this->assertFalse($validator->__invoke(new \stdClass()));
        $this->assertFalse($validator->__invoke(array()));
        $this->assertFalse($validator->__invoke(1));
        $this->assertFalse($validator->__invoke(0));
        $this->assertFalse($validator->__invoke(null));
    }
}
