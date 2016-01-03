<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\IntType;

/**
 * Integer assert test
 *
 * @uses \PHPUnit_Framework_TestCase
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class IntTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
     */

    protected function prepareAssert()
    {
        return new IntType();
    }

    /**
     * Test integer
     */

    public function testInteger()
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(10)
        );
    }

    /**
     * Test string
     */

    public function testString()
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process('10')
        );
    }

    /**
     * Test null
     */

    public function testNull()
    {
        $this->assertNull(
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test object
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage is not integer
     */

    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage is not integer
     */

    public function testArray()
    {
        $this->prepareAssert()->process(array(1));
    }

    /**
     * Test negative string
     */

    public function testNegativeString()
    {
        $this->assertSame(
            -10,
            $this->prepareAssert()->process('-10')
        );
    }

    /**
     * Test bad string
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage is not integer
     */

    public function testBadString()
    {
        $this->prepareAssert()->process('123abc');
    }
}
