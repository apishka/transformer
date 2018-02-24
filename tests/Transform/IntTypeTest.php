<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\IntType;

/**
 * Integer assert test
 */
class IntTypeTest extends \PHPUnit\Framework\TestCase
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
     * Test float
     */
    public function testFloat()
    {
        $this->assertSame(
            0,
            $this->prepareAssert()->process(0.0)
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
        $this->prepareAssert()->process([1]);
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

    /**
     * Test filters
     */
    public function testFilters()
    {
        $this->assertSame(
            1123123,
            $this->prepareAssert()->process('1 123 123')
        );
    }

    /**
     * Test without filters
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */
    public function testWithoutFilters()
    {
        $this->prepareAssert()->process(
            '1 123 123',
            [
                'apply_filters' => false,
            ]
        );
    }
}
