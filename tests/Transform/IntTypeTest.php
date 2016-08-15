<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\IntType;

/**
 * Integer assert test
 */

class IntTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return int
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
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
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
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testBadString()
    {
        $this->prepareAssert()->process('123abc');
    }
}
