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

class EachTest extends \PHPUnit_Framework_TestCase
{
    public function testValidatorShouldPassIfEveryArrayItemPass()
    {
        $v = new Each(new NotEmpty());
        $result = $v->validate(array(1, 2, 3, 4, 5));
        $this->assertTrue($result);
        $result = $v->check(array(1, 2, 3, 4, 5));
        $this->assertTrue($result);
        $result = $v->assert(array(1, 2, 3, 4, 5));
        $this->assertTrue($result);
    }

    public function testValidatorShouldPassIfEveryArrayItemAndKeyPass()
    {
        $v = new Each(new Alpha(), new IntVal());
        $result = $v->validate(array('a', 'b', 'c', 'd', 'e'));
        $this->assertTrue($result);
        $result = $v->check(array('a', 'b', 'c', 'd', 'e'));
        $this->assertTrue($result);
        $result = $v->assert(array('a', 'b', 'c', 'd', 'e'));
        $this->assertTrue($result);
    }

    public function testValidatorShouldPassWithOnlyKeyValidation()
    {
        $v = new Each(null, new IntVal());
        $result = $v->validate(array('a', 'b', 'c', 'd', 'e'));
        $this->assertTrue($result);
        $result = $v->check(array('a', 'b', 'c', 'd', 'e'));
        $this->assertTrue($result);
        $result = $v->assert(array('a', 'b', 'c', 'd', 'e'));
        $this->assertTrue($result);
    }

    /**
     * @expectedException Respect\Validation\Exceptions\EachException
     */
    public function testValidatorShouldNotPassWithOnlyKeyValidation()
    {
        $v = new Each(null, new StrType());
        $result = $v->assert(array('a', 'b', 'c', 'd', 'e'));
        $this->assertTrue($result);
    }

    public function testNotTraversableValidatorShouldFail()
    {
        $v = new Each(new NotEmpty());
        $result = $v->validate(null);
        $this->assertFalse($result);
    }

    public function testValidatorShouldFailOnInvalidItem()
    {
        $v = new Each(new NotEmpty());
        $result = $v->validate(array('', 2, 3, 4, 5));
        $this->assertFalse($result);
    }

    /**
     * @expectedException Respect\Validation\Exceptions\EachException
     */
    public function testAssertShouldFailOnInvalidItem()
    {
        $v = new Each(new IntVal());
        $result = $v->assert(array('a', 2, 3, 4, 5));
        $this->assertFalse($result);
    }

    /**
     * @expectedException Respect\Validation\Exceptions\EachException
     */
    public function testAssertShouldFailOnNonTraversable()
    {
        $v = new Each(new NotEmpty());
        $result = $v->assert(123);
        $this->assertFalse($result);
    }
}
